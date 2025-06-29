<!-- resources/views/components/service-card.blade.php -->
<!-- Tutorial #13: Components in Laravel -->
<!-- Tutorial #50: Building Layout with Components -->

@props(['service'])

<div class="service-card card-custom h-100">
    @if($service->image)
        <div class="card-img-wrapper position-relative overflow-hidden">
            <img src="{{ Storage::url($service->image) }}" 
                 class="card-img-top" 
                 alt="{{ $service->title }}"
                 loading="lazy">
            
            <!-- Price badge -->
            <div class="price-badge position-absolute top-0 end-0 m-3">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    {{ $service->formatted_price }}
                </span>
            </div>
            
            <!-- Category badge -->
            <div class="category-badge position-absolute bottom-0 start-0 m-3">
                <span class="badge bg-dark bg-opacity-75 px-2 py-1">
                    {{ ucfirst($service->category) }}
                </span>
            </div>
        </div>
    @else
        <!-- Default image placeholder -->
        <div class="card-img-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="fas fa-image fa-3x text-muted"></i>
        </div>
    @endif
    
    <div class="card-body d-flex flex-column">
        <div class="card-content flex-grow-1">
            <h5 class="card-title fw-bold mb-2">
                {{ $service->title }}
            </h5>
            
            <p class="card-text text-muted mb-3">
                {{ Str::limit($service->short_description, 120) }}
            </p>
            
            <!-- Service features/highlights -->
            <div class="service-features mb-3">
                <small class="text-muted d-flex align-items-center mb-1">
                    <i class="fas fa-check text-success me-2"></i>
                    {{ __('Professional Quality') }}
                </small>
                <small class="text-muted d-flex align-items-center mb-1">
                    <i class="fas fa-clock text-primary me-2"></i>
                    {{ __('Fast Delivery') }}
                </small>
                <small class="text-muted d-flex align-items-center">
                    <i class="fas fa-support text-info me-2"></i>
                    {{ __('24/7 Support') }}
                </small>
            </div>
        </div>
        
        <!-- Action buttons -->
        <div class="card-actions mt-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('services.show', $service) }}" 
                   class="btn btn-outline-primary flex-grow-1">
                    <i class="fas fa-eye me-1"></i>
                    {{ __('View Details') }}
                </a>
                <a href="{{ route('contact.create', ['service' => $service->slug]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Hover overlay for additional info -->
    <div class="hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
            <h6 class="mb-2">{{ __('Quick Actions') }}</h6>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('services.show', $service) }}" 
                   class="btn btn-light btn-sm">
                    {{ __('Learn More') }}
                </a>
                <a href="{{ route('contact.create', ['service' => $service->slug]) }}" 
                   class="btn btn-primary btn-sm">
                    {{ __('Get Quote') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .service-card {
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .card-img-wrapper {
        position: relative;
        height: 200px;
    }
    
    .card-img-top {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .service-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .price-badge .badge {
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0, 122, 255, 0.3);
    }
    
    .category-badge .badge {
        border-radius: 15px;
        font-size: 0.75rem;
    }
    
    .service-features small {
        font-size: 0.8rem;
        line-height: 1.4;
    }
    
    .card-actions .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .card-actions .btn:hover {
        transform: translateY(-1px);
    }
    
    .hover-overlay {
        background: rgba(0, 122, 255, 0.9);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: inherit;
        backdrop-filter: blur(5px);
    }
    
    .service-card:hover .hover-overlay {
        opacity: 1;
    }
    
    .card-img-placeholder {
        border-bottom: 1px solid #e9ecef;
    }
    
    .card-title {
        color: #1d1d1f;
        line-height: 1.3;
    }
    
    .card-text {
        line-height: 1.5;
        font-size: 0.9rem;
    }
    
    /* Featured service styling */
    .service-card.featured {
        border: 2px solid var(--primary-color);
        position: relative;
    }
    
    .service-card.featured::before {
        content: '{{ __("Featured") }}';
        position: absolute;
        top: -1px;
        left: 20px;
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0 0 8px 8px;
        z-index: 10;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-actions .btn {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }
        
        .hover-overlay {
            display: none; /* Hide hover overlay on mobile for better UX */
        }
    }
    
    /* Animation for card entrance */
    .service-card {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading state */
    .service-card.loading {
        pointer-events: none;
    }
    
    .service-card.loading .card-img-top {
        filter: blur(2px);
    }
    
    .service-card.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 1000;
    }
</style>

<!-- Additional JavaScript for enhanced interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to buttons
        document.querySelectorAll('.service-card .btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!this.classList.contains('btn-sm')) {
                    const card = this.closest('.service-card');
                    card.classList.add('loading');
                    
                    // Remove loading state after navigation (fallback)
                    setTimeout(() => {
                        card.classList.remove('loading');
                    }, 3000);
                }
            });
        });
        
        // Lazy loading for images
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('.card-img-top[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    });
</script>