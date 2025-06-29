<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * ServiceResource - API Tutorial #10: API with Resource Controller
 * 
 * This resource class formats the Service model data for API responses
 * providing consistent structure and hiding sensitive information
 */
class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'category' => $this->category,
            'price' => [
                'amount' => $this->price,
                'formatted' => $this->formatted_price,
                'currency' => 'USD'
            ],
            'status' => $this->status,
            'featured' => $this->featured,
            'sort_order' => $this->sort_order,
            'image' => [
                'url' => $this->image ? Storage::url($this->image) : null,
                'alt' => $this->title,
                'path' => $this->image
            ],
            'meta' => [
                'view_url' => route('services.show', $this->slug),
                'contact_url' => route('contact.create', ['service' => $this->slug]),
            ],
            'timestamps' => [
                'created_at' => $this->created_at?->toISOString(),
                'updated_at' => $this->updated_at?->toISOString(),
                'created_human' => $this->created_at?->diffForHumans(),
                'updated_human' => $this->updated_at?->diffForHumans(),
            ],
            
            // Include additional data when authenticated
            $this->mergeWhen($request->user(), [
                'admin_data' => [
                    'deleted_at' => $this->deleted_at?->toISOString(),
                    'edit_url' => route('admin.services.edit', $this->id),
                    'delete_url' => route('admin.services.destroy', $this->id),
                ]
            ]),
            
            // Include related data when specifically requested
            $this->mergeWhen($request->get('include_relations'), [
                'related_services' => ServiceResource::collection(
                    $this->whenLoaded('relatedServices')
                ),
            ]),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'api_version' => '1.0',
            'generated_at' => now()->toISOString(),
        ];
    }
}

/**
 * ServiceCollection - Custom resource collection for services
 */
class ServiceCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_count' => $this->collection->count(),
                'categories' => $this->collection->pluck('category')->unique()->values(),
                'price_range' => [
                    'min' => $this->collection->min('price'),
                    'max' => $this->collection->max('price'),
                    'average' => round($this->collection->avg('price'), 2)
                ]
            ]
        ];
    }
}