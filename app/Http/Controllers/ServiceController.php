<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

/**
 * ServiceController - Tutorial #9: Controller in Laravel
 * 
 * This controller demonstrates:
 * - Tutorial #41: Insert data in MySQL table with HTML form
 * - Tutorial #42: Get and display data from MySQL Table
 * - Tutorial #43: Delete data from MySQL Table
 * - Tutorial #44: Populate data in HTML form from MySQL Table
 * - Tutorial #45: Update data from MySQL Database Table
 * - Tutorial #46: Search data from MySQL Database Table
 * - Tutorial #47: Pagination in Laravel
 * - Tutorial #48: Delete Multiple Records with MySQL
 */
class ServiceController extends Controller
{
    /**
     * Apply middleware for authentication and authorization
     * Tutorial #23, #24, #25: Middleware implementation
     */
    public function __construct()
    {
        // Only authenticated users can access admin functions
        $this->middleware('auth')->except(['publicIndex', 'show']);
        
        // Only admin users can manage services
        $this->middleware('admin')->except(['publicIndex', 'show']);
    }

    /**
     * Display services for public viewing
     * Tutorial #42: Get and display data from MySQL Table
     * Tutorial #46: Search data from MySQL Database Table
     * Tutorial #47: Pagination in Laravel
     */
    public function publicIndex(Request $request)
    {
        // Start with active services query
        $query = Service::active();
        
        // Tutorial #46: Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->search($searchTerm);
        }
        
        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Filter by price range
        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case 'under_500':
                    $query->where('price', '<', 500);
                    break;
                case '500_1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '1000_5000':
                    $query->whereBetween('price', [1000, 5000]);
                    break;
                case 'over_5000':
                    $query->where('price', '>', 5000);
                    break;
            }
        }
        
        // Sort options
        $sortBy = $request->get('sort', 'sort_order');
        $sortDirection = $request->get('direction', 'asc');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('featured', 'desc')->orderBy('sort_order', 'asc');
                break;
            default:
                $query->orderBy('sort_order', 'asc');
        }
        
        // Tutorial #47: Pagination
        $services = $query->paginate(9)->withQueryString();
        
        // Get unique categories for filter dropdown
        $categories = Service::active()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort();
        
        return view('services.index', compact('services', 'categories'));
    }

    /**
     * Display the specified service for public viewing
     * Tutorial #42: Get and display data from MySQL Table
     */
    public function show(Service $service)
    {
        // Ensure service is active for public viewing
        if ($service->status !== 'active') {
            abort(404);
        }
        
        // Get related services in the same category
        $relatedServices = Service::active()
            ->where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();
        
        return view('services.show', compact('service', 'relatedServices'));
    }

    /**
     * Display services for admin management
     * Tutorial #42: Get and display data from MySQL Table
     * Tutorial #46: Search functionality
     * Tutorial #47: Pagination
     */
    public function index(Request $request)
    {
        // Include soft deleted services for admin
        $query = Service::withTrashed();
        
        // Tutorial #46: Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->search($searchTerm);
        }
        
        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('status', 'active')->whereNull('deleted_at');
                    break;
                case 'inactive':
                    $query->where('status', 'inactive')->whereNull('deleted_at');
                    break;
                case 'deleted':
                    $query->onlyTrashed();
                    break;
            }
        }
        
        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Tutorial #47: Pagination with larger page size for admin
        $services = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get statistics for dashboard
        $stats = [
            'total' => Service::count(),
            'active' => Service::where('status', 'active')->count(),
            'inactive' => Service::where('status', 'inactive')->count(),
            'deleted' => Service::onlyTrashed()->count(),
        ];
        
        return view('admin.services.index', compact('services', 'stats'));
    }

    /**
     * Show the form for creating a new service
     * Tutorial #14: Input fields and form submit
     */
    public function create()
    {
        $categories = Service::distinct()->pluck('category')->filter()->sort();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created service
     * Tutorial #41: Insert data in MySQL table with HTML form
     * Tutorial #38: Upload file | upload and display image
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        
        // Tutorial #38: Handle file upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }
        
        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = Service::max('sort_order') + 1;
        }
        
        // Tutorial #41: Insert data into database
        $service = Service::create($data);
        
        // Tutorial #37: Flash session message
        return redirect()->route('admin.services.index')
            ->with('success', __('Service created successfully.'));
    }

    /**
     * Show the form for editing a service
     * Tutorial #44: Populate data in HTML form from MySQL Table
     */
    public function edit(Service $service)
    {
        $categories = Service::distinct()->pluck('category')->filter()->sort();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service
     * Tutorial #45: Update data from MySQL Database Table
     * Tutorial #38: File upload handling
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        
        // Tutorial #38: Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }
        
        // Tutorial #45: Update data in database
        $service->update($data);
        
        // Tutorial #37: Flash session message
        return redirect()->route('admin.services.index')
            ->with('success', __('Service updated successfully.'));
    }

    /**
     * Remove the specified service
     * Tutorial #43: Delete data from MySQL Table
     */
    public function destroy(Service $service)
    {
        // Delete associated image file
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        // Tutorial #43: Soft delete the service
        $service->delete();
        
        // Tutorial #37: Flash session message
        return redirect()->route('admin.services.index')
            ->with('success', __('Service deleted successfully.'));
    }

    /**
     * Delete multiple services at once
     * Tutorial #48: Delete Multiple Records with MySQL
     */
    public function bulkDelete(Request $request)
    {
        // Validate the request
        $request->validate([
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id'
        ]);
        
        // Get services to delete
        $services = Service::whereIn('id', $request->services)->get();
        
        // Delete associated image files
        foreach ($services as $service) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
        }
        
        // Tutorial #48: Bulk delete services
        Service::whereIn('id', $request->services)->delete();
        
        $count = count($request->services);
        
        // Tutorial #37: Flash session message
        return redirect()->route('admin.services.index')
            ->with('success', __(':count services deleted successfully.', ['count' => $count]));
    }

    /**
     * Restore a soft-deleted service
     */
    public function restore($id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $service->restore();
        
        return redirect()->route('admin.services.index')
            ->with('success', __('Service restored successfully.'));
    }

    /**
     * Permanently delete a service
     */
    public function forceDelete($id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        
        // Delete image file
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        // Permanently delete
        $service->forceDelete();
        
        return redirect()->route('admin.services.index')
            ->with('success', __('Service permanently deleted.'));
    }

    /**
     * Toggle service featured status
     */
    public function toggleFeatured(Service $service)
    {
        $service->update(['featured' => !$service->featured]);
        
        $status = $service->featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', __('Service :status successfully.', ['status' => $status]));
    }

    /**
     * Duplicate a service
     */
    public function duplicate(Service $service)
    {
        $newService = $service->replicate();
        $newService->title = $service->title . ' (Copy)';
        $newService->slug = null; // Will be regenerated by mutator
        $newService->featured = false;
        $newService->sort_order = Service::max('sort_order') + 1;
        
        // Copy image if exists
        if ($service->image) {
            $extension = pathinfo($service->image, PATHINFO_EXTENSION);
            $newImagePath = 'services/' . uniqid() . '.' . $extension;
            Storage::disk('public')->copy($service->image, $newImagePath);
            $newService->image = $newImagePath;
        }
        
        $newService->save();
        
        return redirect()->route('admin.services.edit', $newService)
            ->with('success', __('Service duplicated successfully. Please update the details.'));
    }

    /**
     * Export services data
     */
    public function export(Request $request)
    {
        $query = Service::query();
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $services = $query->get();
        
        $filename = 'services_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Title', 'Category', 'Price', 'Status', 
                'Featured', 'Created At', 'Updated At'
            ]);
            
            // CSV data
            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->title,
                    $service->category,
                    $service->price,
                    $service->status,
                    $service->featured ? 'Yes' : 'No',
                    $service->created_at->format('Y-m-d H:i:s'),
                    $service->updated_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update service ordering
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.sort_order' => 'required|integer|min:0'
        ]);
        
        foreach ($request->services as $serviceData) {
            Service::where('id', $serviceData['id'])
                ->update(['sort_order' => $serviceData['sort_order']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => __('Service order updated successfully.')
        ]);
    }
}