<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Service Model - Multiple Tutorial Demonstrations
 * 
 * This model demonstrates:
 * - Tutorial #28: Eloquent Model
 * - Tutorial #58: Accessors
 * - Tutorial #59: Mutators
 * - Tutorial #60: One to One Relationship
 * - Tutorial #61: One to Many Relationship
 * - Tutorial #62: Many to One Relationship
 */
class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'image',
        'price',
        'category',
        'status',
        'featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'tags',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_by',
        'updated_by'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ===========================
    // MUTATORS (Tutorial #59)
    // ===========================

    /**
     * Set the title attribute and auto-generate slug
     * Tutorial #59: Mutators
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        
        // Auto-generate slug if not manually set
        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }

    /**
     * Set the slug attribute with uniqueness check
     * Tutorial #59: Mutators
     */
    public function setSlugAttribute(?string $value): void
    {
        if ($value) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }

    /**
     * Set the price attribute with formatting
     * Tutorial #59: Mutators
     */
    public function setPriceAttribute($value): void
    {
        // Remove any currency symbols and convert to decimal
        $cleanPrice = preg_replace('/[^0-9.]/', '', $value);
        $this->attributes['price'] = number_format((float)$cleanPrice, 2, '.', '');
    }

    /**
     * Set the tags attribute
     * Tutorial #59: Mutators
     */
    public function setTagsAttribute($value): void
    {
        if (is_string($value)) {
            // Convert comma-separated string to array
            $this->attributes['tags'] = json_encode(
                array_map('trim', explode(',', $value))
            );
        } elseif (is_array($value)) {
            $this->attributes['tags'] = json_encode($value);
        }
    }

    /**
     * Set the category attribute with proper formatting
     * Tutorial #59: Mutators
     */
    public function setCategoryAttribute(string $value): void
    {
        $this->attributes['category'] = Str::slug($value, '_');
    }

    // ===========================
    // ACCESSORS (Tutorial #58)
    // ===========================

    /**
     * Get the formatted price attribute
     * Tutorial #58: Accessors
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get the price with currency
     * Tutorial #58: Accessors
     */
    public function getPriceWithCurrencyAttribute(): array
    {
        return [
            'amount' => $this->price,
            'formatted' => $this->formatted_price,
            'currency' => 'USD',
            'symbol' => '$'
        ];
    }

    /**
     * Get the formatted category name
     * Tutorial #58: Accessors
     */
    public function getFormattedCategoryAttribute(): string
    {
        return Str::title(str_replace('_', ' ', $this->category));
    }

    /**
     * Get the excerpt from description
     * Tutorial #58: Accessors
     */
    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->description), 150);
    }

    /**
     * Get the read time estimate
     * Tutorial #58: Accessors
     */
    public function getReadTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->description));
        $minutes = ceil($wordCount / 200); // Average reading speed
        return $minutes . ' min read';
    }

    /**
     * Get the status badge information
     * Tutorial #58: Accessors
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'active' => ['class' => 'badge-success', 'text' => 'Active'],
            'inactive' => ['class' => 'badge-warning', 'text' => 'Inactive'],
            'draft' => ['class' => 'badge-secondary', 'text' => 'Draft'],
            default => ['class' => 'badge-secondary', 'text' => 'Unknown']
        };
    }

    /**
     * Get the full image URL
     * Tutorial #58: Accessors
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get SEO meta data
     * Tutorial #58: Accessors
     */
    public function getSeoMetaAttribute(): array
    {
        return [
            'title' => $this->meta_title ?: $this->title,
            'description' => $this->meta_description ?: $this->excerpt,
            'keywords' => is_array($this->tags) ? implode(', ', $this->tags) : '',
            'canonical_url' => route('services.show', $this->slug)
        ];
    }

    // ===========================
    // RELATIONSHIPS (Tutorial #60-62)
    // ===========================

    /**
     * Get the reviews for the service
     * Tutorial #61: One to Many Relationship
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ServiceReview::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get approved reviews only
     * Tutorial #61: One to Many Relationship
     */
    public function approvedReviews(): HasMany
    {
        return $this->reviews()->where('status', 'approved');
    }

    /**
     * Get the service inquiries
     * Tutorial #61: One to Many Relationship
     */
    public function inquiries(): HasMany
    {
        return $this->hasMany(ServiceInquiry::class);
    }

    /**
     * Get the user who created this service
     * Tutorial #62: Many to One Relationship (Belongs To)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this service
     * Tutorial #62: Many to One Relationship (Belongs To)
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the service category model (if using separate category table)
     * Tutorial #62: Many to One Relationship (Belongs To)
     */
    public function categoryModel(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category', 'slug');
    }

    /**
     * Get the service portfolio items
     * Tutorial #61: One to Many Relationship
     */
    public function portfolioItems(): HasMany
    {
        return $this->hasMany(PortfolioItem::class);
    }

    // ===========================
    // QUERY SCOPES (Tutorial #46)
    // ===========================

    /**
     * Scope a query to only include active services
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured services
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to search services
     * Tutorial #46: Search data from MySQL Database Table
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%")
              ->orWhere('category', 'like', "%{$term}%")
              ->orWhereJsonContains('tags', $term);
        });
    }

    /**
     * Scope a query by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query by price range
     */
    public function scopeByPriceRange($query, float $min = null, float $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        
        return $query;
    }

    /**
     * Scope a query to get popular services (based on inquiries)
     */
    public function scopePopular($query, int $limit = 10)
    {
        return $query->withCount('inquiries')
                    ->orderBy('inquiries_count', 'desc')
                    ->limit($limit);
    }

    // ===========================
    // HELPER METHODS
    // ===========================

    /**
     * Generate a unique slug for the service
     */
    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Check if slug exists (excluding current model if updating)
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists in database
     */
    private function slugExists(string $slug): bool
    {
        $query = static::where('slug', $slug);
        
        // Exclude current model if updating
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }
        
        return $query->exists();
    }

    /**
     * Get related services in the same category
     */
    public function getRelatedServices(int $limit = 3)
    {
        return static::active()
            ->where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->orderBy('featured', 'desc')
            ->orderBy('sort_order')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculate average rating from reviews
     */
    public function getAverageRating(): float
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    /**
     * Get rating statistics
     */
    public function getRatingStats(): array
    {
        $reviews = $this->approvedReviews;
        $totalReviews = $reviews->count();
        
        if ($totalReviews === 0) {
            return [
                'average' => 0,
                'total' => 0,
                'distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]
            ];
        }

        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $reviews->where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round(($count / $totalReviews) * 100, 1)
            ];
        }

        return [
            'average' => round($this->getAverageRating(), 1),
            'total' => $totalReviews,
            'distribution' => $distribution
        ];
    }

    /**
     * Check if service is available for booking
     */
    public function isAvailable(): bool
    {
        return $this->status === 'active' && !$this->trashed();
    }

    /**
     * Get service availability status
     */
    public function getAvailabilityStatus(): array
    {
        if ($this->trashed()) {
            return ['status' => 'deleted', 'message' => 'Service is no longer available'];
        }

        return match($this->status) {
            'active' => ['status' => 'available', 'message' => 'Available for booking'],
            'inactive' => ['status' => 'unavailable', 'message' => 'Currently unavailable'],
            'draft' => ['status' => 'draft', 'message' => 'Coming soon'],
            default => ['status' => 'unknown', 'message' => 'Status unknown']
        };
    }

    // ===========================
    // MODEL EVENTS
    // ===========================

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            // Set creator if authenticated
            if (auth()->check()) {
                $service->created_by = auth()->id();
            }
            
            // Set sort order if not provided
            if (!$service->sort_order) {
                $service->sort_order = static::max('sort_order') + 1;
            }
        });

        static::updating(function (Service $service) {
            // Set updater if authenticated
            if (auth()->check()) {
                $service->updated_by = auth()->id();
            }
        });

        static::deleting(function (Service $service) {
            // Clean up related data when deleting
            $service->reviews()->delete();
            $service->inquiries()->delete();
            $service->portfolioItems()->delete();
        });
    }
}