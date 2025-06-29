<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * ServiceApiController - API Tutorials #1-10
 * 
 * This controller demonstrates:
 * - API Tutorial #1: What is API in Laravel
 * - API Tutorial #3: Make First GET API with database
 * - API Tutorial #5: POST API with database
 * - API Tutorial #6: PUT API with database  
 * - API Tutorial #7: Delete API with database
 * - API Tutorial #8: Search API with database
 * - API Tutorial #9: Validate API Data
 * - API Tutorial #10: API with Resource Controller
 */
class ServiceApiController extends Controller
{
    /**
     * Apply rate limiting middleware for API protection
     * API Tutorial #2: API security and throttling
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'search']);
        $this->middleware('throttle:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of services
     * API Tutorial #3: Make First GET API with database
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Service::active();
            
            // Filter by category
            if ($request->has('category')) {
                $query->where('category', $request->category);
            }
            
            // Filter by featured
            if ($request->has('featured')) {
                $query->where('featured', $request->boolean('featured'));
            }
            
            // Filter by price range
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'sort_order');
            $sortDirection = $request->get('sort_direction', 'asc');
            
            $allowedSorts = ['title', 'price', 'created_at', 'sort_order'];
            if (in_array($sortBy, $allowedSorts)) {
                $query->orderBy($sortBy, $sortDirection);
            }
            
            // Pagination
            $perPage = min($request->get('per_page', 15), 50); // Max 50 items per page
            $services = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => ServiceResource::collection($services),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                    'from' => $services->firstItem(),
                    'to' => $services->lastItem(),
                ],
                'message' => 'Services retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve services',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Store a newly created service
     * API Tutorial #5: POST API with database
     * API Tutorial #9: Validate API Data
     * 
     * @param ServiceRequest $request
     * @return JsonResponse
     */
    public function store(ServiceRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('services', 'public');
            }
            
            // Set sort order if not provided
            if (!isset($data['sort_order'])) {
                $data['sort_order'] = Service::max('sort_order') + 1;
            }
            
            $service = Service::create($data);
            
            return response()->json([
                'success' => true,
                'data' => new ServiceResource($service),
                'message' => 'Service created successfully'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified service
     * API Tutorial #3: GET API for single resource
     * 
     * @param Service $service
     * @return JsonResponse
     */
    public function show(Service $service): JsonResponse
    {
        try {
            // Check if service is active for public API
            if ($service->status !== 'active' && !auth('sanctum')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service not found'
                ], 404);
            }
            
            // Load related services
            $relatedServices = Service::active()
                ->where('category', $service->category)
                ->where('id', '!=', $service->id)
                ->limit(3)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => new ServiceResource($service),
                'related_services' => ServiceResource::collection($relatedServices),
                'message' => 'Service retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve service',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Update the specified service
     * API Tutorial #6: PUT API with database
     * API Tutorial #9: Validate API Data
     * 
     * @param ServiceRequest $request
     * @param Service $service
     * @return JsonResponse
     */
    public function update(ServiceRequest $request, Service $service): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $data['image'] = $request->file('image')->store('services', 'public');
            }
            
            $service->update($data);
            
            return response()->json([
                'success' => true,
                'data' => new ServiceResource($service->fresh()),
                'message' => 'Service updated successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Remove the specified service
     * API Tutorial #7: Delete API with database
     * 
     * @param Service $service
     * @return JsonResponse
     */
    public function destroy(Service $service): JsonResponse
    {
        try {
            // Delete associated image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $service->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Search services
     * API Tutorial #8: Search API with database
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            // Validate search parameters
            $request->validate([
                'query' => 'required|string|min:2|max:100',
                'category' => 'nullable|string|max:50',
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0',
                'per_page' => 'nullable|integer|min:1|max:50'
            ]);
            
            $query = Service::active();
            
            // Search in title, description, and category
            $searchTerm = $request->query;
            $query->search($searchTerm);
            
            // Additional filters
            if ($request->has('category')) {
                $query->where('category', $request->category);
            }
            
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $services = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => ServiceResource::collection($services),
                'search_query' => $searchTerm,
                'total_results' => $services->total(),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ],
                'message' => 'Search completed successfully'
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get service categories
     * 
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        try {
            $categories = Service::active()
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort()
                ->values();
            
            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categories retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get featured services
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function featured(Request $request): JsonResponse
    {
        try {
            $limit = min($request->get('limit', 6), 20);
            
            $services = Service::active()
                ->featured()
                ->orderBy('sort_order')
                ->limit($limit)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => ServiceResource::collection($services),
                'message' => 'Featured services retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve featured services',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get service statistics
     * 
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_services' => Service::count(),
                'active_services' => Service::active()->count(),
                'featured_services' => Service::featured()->count(),
                'categories_count' => Service::distinct('category')->count(),
                'average_price' => Service::active()->avg('price'),
                'price_range' => [
                    'min' => Service::active()->min('price'),
                    'max' => Service::active()->max('price')
                ],
                'by_category' => Service::active()
                    ->groupBy('category')
                    ->selectRaw('category, count(*) as count')
                    ->pluck('count', 'category')
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistics retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}