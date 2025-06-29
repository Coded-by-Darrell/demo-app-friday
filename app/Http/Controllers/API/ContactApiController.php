<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * ContactApiController - API Tutorials for Contact Management
 * 
 * This controller demonstrates:
 * - API Tutorial #5: POST API with database (store contact)
 * - API Tutorial #9: Validate API Data
 * - Contact form submission via API
 */
class ContactApiController extends Controller
{
    /**
     * Apply authentication middleware for admin functions
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index', 'show', 'update', 'destroy']);
        $this->middleware('throttle:10,1')->only(['store']); // Limit contact form submissions
    }

    /**
     * Display a listing of contact submissions (Admin only)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $query = Contact::query();

            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filter by date range
            if ($request->has('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->has('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            // Search in name, email, subject, or message
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%")
                      ->orWhere('subject', 'like', "%{$searchTerm}%")
                      ->orWhere('message', 'like', "%{$searchTerm}%")
                      ->orWhere('company', 'like', "%{$searchTerm}%");
                });
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            
            $allowedSorts = ['created_at', 'name', 'subject', 'status'];
            if (in_array($sortBy, $allowedSorts)) {
                $query->orderBy($sortBy, $sortDirection);
            }

            // Pagination
            $perPage = min($request->get('per_page', 15), 50);
            $contacts = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => ContactResource::collection($contacts),
                'pagination' => [
                    'current_page' => $contacts->currentPage(),
                    'last_page' => $contacts->lastPage(),
                    'per_page' => $contacts->perPage(),
                    'total' => $contacts->total(),
                ],
                'statistics' => [
                    'total_contacts' => Contact::count(),
                    'unread_contacts' => Contact::where('status', 'unread')->count(),
                    'today_contacts' => Contact::whereDate('created_at', today())->count(),
                ],
                'message' => 'Contacts retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contacts',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Store a new contact submission
     * API Tutorial #5: POST API with database
     * API Tutorial #9: Validate API Data
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // API-specific validation with rate limiting consideration
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'company' => 'nullable|string|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|min:10|max:2000',
                'service_interest' => 'nullable|array',
                'service_interest.*' => 'string|max:100',
                'budget_range' => 'nullable|string|in:under_5k,5k_10k,10k_25k,25k_50k,over_50k',
                'preferred_contact' => 'required|in:email,phone,either',
                'source' => 'nullable|string|max:50', // Track API vs web submissions
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check for duplicate submissions (same email and subject within last hour)
            $recentSubmission = Contact::where('email', $request->email)
                ->where('subject', $request->subject)
                ->where('created_at', '>', now()->subHour())
                ->first();

            if ($recentSubmission) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate submission detected. Please wait before submitting again.'
                ], 429);
            }

            // Prepare data
            $data = $validator->validated();
            $data['source'] = $data['source'] ?? 'api';
            
            // Convert service_interest array to string if present
            if (isset($data['service_interest']) && is_array($data['service_interest'])) {
                $data['service_interest'] = implode(', ', $data['service_interest']);
            }

            // Create contact submission
            $contact = Contact::create($data);

            // Send email notification (Tutorial #64: Send Email)
            try {
                Mail::to(config('mail.from.address'))->send(new ContactFormMail($contact));
                $emailSent = true;
            } catch (\Exception $e) {
                \Log::error('Failed to send contact email: ' . $e->getMessage());
                $emailSent = false;
            }

            return response()->json([
                'success' => true,
                'data' => new ContactResource($contact),
                'email_sent' => $emailSent,
                'message' => 'Contact submission received successfully. We will get back to you soon!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process contact submission',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified contact (Admin only)
     * 
     * @param Request $request
     * @param Contact $contact
     * @return JsonResponse
     */
    public function show(Request $request, Contact $contact): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Mark as read if it was unread
            if ($contact->status === 'unread') {
                $contact->update(['status' => 'read']);
            }

            return response()->json([
                'success' => true,
                'data' => new ContactResource($contact),
                'message' => 'Contact retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Update contact status (Admin only)
     * 
     * @param Request $request
     * @param Contact $contact
     * @return JsonResponse
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:unread,read,responded',
                'admin_notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $contact->update($validator->validated());

            return response()->json([
                'success' => true,
                'data' => new ContactResource($contact),
                'message' => 'Contact updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Delete contact submission (Admin only)
     * 
     * @param Request $request
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Request $request, Contact $contact): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete contact',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get contact statistics (Admin only)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function statistics(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $stats = [
                'total_contacts' => Contact::count(),
                'unread_contacts' => Contact::where('status', 'unread')->count(),
                'read_contacts' => Contact::where('status', 'read')->count(),
                'responded_contacts' => Contact::where('status', 'responded')->count(),
                'today_contacts' => Contact::whereDate('created_at', today())->count(),
                'this_week_contacts' => Contact::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                'this_month_contacts' => Contact::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'popular_services' => Contact::whereNotNull('service_interest')
                    ->get()
                    ->flatMap(function ($contact) {
                        return explode(', ', $contact->service_interest);
                    })
                    ->countBy()
                    ->sortDesc()
                    ->take(5),
                'budget_distribution' => Contact::whereNotNull('budget_range')
                    ->groupBy('budget_range')
                    ->selectRaw('budget_range, count(*) as count')
                    ->pluck('count', 'budget_range'),
                'contact_methods' => Contact::groupBy('preferred_contact')
                    ->selectRaw('preferred_contact, count(*) as count')
                    ->pluck('count', 'preferred_contact'),
                'recent_trend' => Contact::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Contact statistics retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Export contacts data (Admin only)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function export(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!$request->user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $query = Contact::query();

            // Apply filters
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->has('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $contacts = $query->orderBy('created_at', 'desc')->get();

            $exportData = $contacts->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'company' => $contact->company,
                    'subject' => $contact->subject,
                    'message' => $contact->message,
                    'service_interest' => $contact->service_interest,
                    'budget_range' => $contact->budget_range,
                    'preferred_contact' => $contact->preferred_contact,
                    'status' => $contact->status,
                    'source' => $contact->source ?? 'web',
                    'created_at' => $contact->created_at->toISOString(),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $exportData,
                'total_records' => $exportData->count(),
                'generated_at' => now()->toISOString(),
                'message' => 'Contacts exported successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export contacts',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}