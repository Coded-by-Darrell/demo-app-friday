<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ContactResource - API Tutorial #10: API with Resource Controller
 * 
 * This resource class formats the Contact model data for API responses
 * providing consistent structure and appropriate data exposure
 */
class ContactResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'subject' => $this->subject,
            'message' => $this->message,
            'service_interest' => $this->service_interest ? 
                explode(', ', $this->service_interest) : null,
            'budget_range' => [
                'value' => $this->budget_range,
                'label' => $this->getBudgetRangeLabel()
            ],
            'preferred_contact' => [
                'value' => $this->preferred_contact,
                'label' => $this->getPreferredContactLabel()
            ],
            'status' => [
                'value' => $this->status,
                'label' => $this->getStatusLabel(),
                'color' => $this->getStatusColor()
            ],
            'source' => $this->source ?? 'web',
            'timestamps' => [
                'created_at' => $this->created_at->toISOString(),
                'updated_at' => $this->updated_at->toISOString(),
                'created_human' => $this->created_at->diffForHumans(),
                'updated_human' => $this->updated_at->diffForHumans(),
            ],
            
            // Include admin-only data when user is authenticated as admin
            $this->mergeWhen($request->user()?->is_admin, [
                'admin_data' => [
                    'admin_notes' => $this->admin_notes,
                    'ip_address' => $this->ip_address,
                    'user_agent' => $this->user_agent,
                    'actions' => [
                        'mark_read_url' => route('api.contacts.update', $this->id),
                        'delete_url' => route('api.contacts.destroy', $this->id),
                    ]
                ]
            ])
        ];
    }

    /**
     * Get budget range label
     * 
     * @return string|null
     */
    private function getBudgetRangeLabel(): ?string
    {
        return match($this->budget_range) {
            'under_5k' => 'Under $5,000',
            '5k_10k' => '$5,000 - $10,000',
            '10k_25k' => '$10,000 - $25,000',
            '25k_50k' => '$25,000 - $50,000',
            'over_50k' => 'Over $50,000',
            default => null
        };
    }

    /**
     * Get preferred contact method label
     * 
     * @return string
     */
    private function getPreferredContactLabel(): string
    {
        return match($this->preferred_contact) {
            'email' => 'Email',
            'phone' => 'Phone',
            'either' => 'Either Email or Phone',
            default => 'Email'
        };
    }

    /**
     * Get status label
     * 
     * @return string
     */
    private function getStatusLabel(): string
    {
        return match($this->status) {
            'unread' => 'Unread',
            'read' => 'Read',
            'responded' => 'Responded',
            default => 'Unread'
        };
    }

    /**
     * Get status color for UI
     * 
     * @return string
     */
    private function getStatusColor(): string
    {
        return match($this->status) {
            'unread' => 'warning',
            'read' => 'info',
            'responded' => 'success',
            default => 'secondary'
        };
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