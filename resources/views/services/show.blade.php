<!-- resources/views/services/show.blade.php -->
<!-- Tutorial #42: Get and display data from MySQL Table -->
<!-- Tutorial #27: Display database data on UI -->
<!-- Tutorial #60-62: Relationships display -->

@extends('layouts.app')

@section('title', $service->seo_meta['title'] . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Service Hero Section -->
<section class="service-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.public') }}">{{ __('Services') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $service->title }}
                        </li>
                    </ol>
                </nav>
                
                <div class="service-badges mb-3">
                    <span class="badge bg-primary me-2">{{ $service->formatted_category }}</span>
                    @if($service->featured)
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-star me-1"></i>{{ __('Featured') }}
                        </span>
                    @endif
                </div>
                
                <h1 class="display-4 fw-bold mb-3">{{ $service->title }}</h1>
                <p class="lead text-muted mb-4">{{ $service->short_description }}</p>
                
                <div class="service-meta d-flex flex-wrap gap-4 mb-4">
                    <div class="meta-item">
                        <i class="fas fa-tag text-primary me-2"></i>
                        <span class="fw-bold">{{ __('Category') }}:</span>
                        <span>{{ $service->formatted_category }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock text-success me-2"></i>
                        <span class="fw-bold">{{ __('Read Time') }}:</span>
                        <span>{{ $service->read_time }}</span>
                    </div>
                </div>
                
                <div class="service-price mb-4">
                    <span class="price-label text-muted">{{ __('Starting at') }}</span>
                    <span class="price-amount display-6 fw-bold text-primary">{{ $service->formatted_price }}</span>
                </div>
                
                <div class="service-actions d-flex gap-3 flex-wrap">
                    <a href="{{ route('contact.create', ['service' => $service->slug]) }}" 
                       class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        {{ __('Get Quote') }}
                    </a>
                    <button class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#quickCallModal">
                        <i class="fas fa-phone me-2"></i>
                        {{ __('Schedule Call') }}
                    </button>
                    <button class="btn btn-outline-secondary btn-lg" onclick="shareService()">
                        <i class="fas fa-share-alt me-2"></i>
                        {{ __('Share') }}
                    </button>
                </div>
            </div>
            
            <div class="col-lg-6">
                @if($service->image_url)
                    <div class="service-image">
                        <img src="{{ $service->image_url }}" 
                             alt="{{ $service->title }}" 
                             class="img-fluid rounded-3 shadow-lg">
                    </div>
                @else
                    <div class="service-placeholder bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <p class="mb-0">{{ __('Service Image Coming Soon') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Service Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Service Description -->
                <div class="service-content">
                    <h2 class="mb-4">{{ __('Service Overview') }}</h2>
                    <div class="content-text">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                
                <!-- Service Features -->
                <div class="service-features mt-5">
                    <h3 class="mb-4">{{ __('What\'s Included') }}</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('Professional Quality Delivery') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('24/7 Customer Support') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('Unlimited Revisions') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('Money-Back Guarantee') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('Fast Turnaround Time') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>{{ __('Source Code Included') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Service Process -->
                <div class="service-process mt-5">
                    <h3 class="mb-4">{{ __('Our Process') }}</h3>
                    <div class="process-steps">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>{{ __('Discovery & Planning') }}</h5>
                                <p class="text-muted mb-0">{{ __('We start by understanding your requirements and business goals.') }}</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>{{ __('Design & Development') }}</h5>
                                <p class="text-muted mb-0">{{ __('Our team creates and develops your solution with attention to detail.') }}</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>{{ __('Testing & Review') }}</h5>
                                <p class="text-muted mb-0">{{ __('Thorough testing and your feedback ensure perfect results.') }}</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>{{ __('Delivery & Support') }}</h5>
                                <p class="text-muted mb-0">{{ __('Final delivery with ongoing support and maintenance.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tags -->
                @if($service->tags && count($service->tags) > 0)
                    <div class="service-tags mt-5">
                        <h5 class="mb-3">{{ __('Related Technologies') }}</h5>
                        <div class="tags-container">
                            @foreach($service->tags as $tag)
                                <span class="tag-item badge bg-light text-dark me-2 mb-2">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="service-sidebar">
                    <!-- Quick Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Service Details') }}</h5>
                            
                            <div class="detail-item">
                                <span class="detail-label">{{ __('Price') }}:</span>
                                <span class="detail-value text-primary fw-bold">{{ $service->formatted_price }}</span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">{{ __('Category') }}:</span>
                                <span class="detail-value">{{ $service->formatted_category }}</span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">{{ __('Availability') }}:</span>
                                @php $availability = $service->getAvailabilityStatus() @endphp
                                <span class="detail-value">
                                    <span class="badge bg-{{ $availability['status'] === 'available' ? 'success' : 'warning' }}">
                                        {{ $availability['message'] }}
                                    </span>
                                </span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('contact.create', ['service' => $service->slug]) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-envelope me-2"></i>
                                    {{ __('Get Started') }}
                                </a>
                                <a href="tel:+639123456789" class="btn btn-outline-primary">
                                    <i class="fas fa-phone me-2"></i>
                                    {{ __('Call Now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Need Help?') }}</h5>
                            <p class="card-text text-muted">{{ __('Our experts are ready to help you choose the right solution.') }}</p>
                            
                            <div class="contact-item mb-3">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <small>hello@innovations-marketing.com</small>
                            </div>
                            
                            <div class="contact-item mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <small>+63 912 345 6789</small>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <small>{{ __('Mon-Fri: 8AM-6PM') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Frequently Asked') }}</h5>
                            
                            <div class="accordion accordion-flush" id="serviceAccordion">
                                <div class="accordion-item border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed p-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            {{ __('How long does it take?') }}
                                        </button>
                                    </h6>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#serviceAccordion">
                                        <div class="accordion-body p-0 pt-2">
                                            <small class="text-muted">{{ __('Project timeline varies based on complexity, typically 2-6 weeks.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed p-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            {{ __('Do you provide support?') }}
                                        </button>
                                    </h6>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#serviceAccordion">
                                        <div class="accordion-body p-0 pt-2">
                                            <small class="text-muted">{{ __('Yes, we provide 3 months of free support and maintenance.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed p-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            {{ __('Can I make changes?') }}
                                        </button>
                                    </h6>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#serviceAccordion">
                                        <div class="accordion-body p-0 pt-2">
                                            <small class="text-muted">{{ __('Absolutely! We offer unlimited revisions during development.') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Services Section (Tutorial #60-62: Relationships) -->
@if($relatedServices->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="mb-3">{{ __('Related Services') }}</h3>
                <p class="text-muted">{{ __('Other services in the same category that might interest you') }}</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($relatedServices as $relatedService)
                <div class="col-md-4">
                    <x-service-card :service="$relatedService" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Quick Call Modal -->
<div class="modal fade" id="quickCallModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Schedule a Call') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Let\'s discuss your project requirements. Choose your preferred time:') }}</p>
                
                <div class="time-slots">
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 time-slot" data-time="morning">
                                <i class="fas fa-sun me-2"></i>
                                {{ __('Morning') }}<br>
                                <small>9:00 AM - 12:00 PM</small>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 time-slot" data-time="afternoon">
                                <i class="fas fa-clock me-2"></i>
                                {{ __('Afternoon') }}<br>
                                <small>1:00 PM - 5:00 PM</small>
                            </button>
                        </div>
                    </div>
                </div>
                
                <form id="callScheduleForm" class="mt-4" style="display: none;">
                    <div class="mb-3">
                        <label for="callName" class="form-label">{{ __('Your Name') }}</label>
                        <input type="text" class="form-control" id="callName" required>
                    </div>
                    <div class="mb-3">
                        <label for="callPhone" class="form-label">{{ __('Phone Number') }}</label>
                        <input type="tel" class="form-control" id="callPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="callEmail" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="callEmail" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="scheduleCallBtn" style="display: none;">
                    {{ __('Schedule Call') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .service-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 4rem 0;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--primary-color);
    }
    
    .service-badges .badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
    
    .service-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .price-amount {
        color: var(--primary-color) !important;
    }
    
    .service-image img {
        transition: transform 0.3s ease;
    }
    
    .service-image:hover img {
        transform: scale(1.02);
    }
    
    .content-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        font-weight: 500;
    }
    
    .process-steps .step-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .process-steps .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 50px;
        width: 2px;
        height: 50px;
        background: linear-gradient(to bottom, var(--primary-color), transparent);
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        flex-shrink: 0;
    }
    
    .step-content h5 {
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }
    
    .tag-item {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        background: white !important;
        color: var(--dark-color) !important;
    }
    
    .service-sidebar .card {
        position: sticky;
        top: 120px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 500;
        color: var(--medium-gray);
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .accordion-button {
        background: none;
        border: none;
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .accordion-button:not(.collapsed) {
        color: var(--primary-color);
    }
    
    .time-slot {
        height: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .time-slot:hover,
    .time-slot.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .service-hero {
            padding: 2rem 0;
        }
        
        .display-4 {
            font-size: 2rem;
        }
        
        .service-actions {
            justify-content: center;
        }
        
        .service-sidebar .card {
            position: static;
        }
        
        .process-steps .step-item::after {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Time slot selection
        const timeSlots = document.querySelectorAll('.time-slot');
        const callForm = document.getElementById('callScheduleForm');
        const scheduleBtn = document.getElementById('scheduleCallBtn');
        
        timeSlots.forEach(slot => {
            slot.addEventListener('click', function() {
                timeSlots.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                callForm.style.display = 'block';
                scheduleBtn.style.display = 'inline-block';
            });
        });
        
        // Schedule call
        scheduleBtn.addEventListener('click', function() {
            const form = callForm;
            if (form.checkValidity()) {
                // Here you would normally send the data to your backend
                alert('{{ __("Call scheduled successfully! We will contact you soon.") }}');
                bootstrap.Modal.getInstance(document.getElementById('quickCallModal')).hide();
            } else {
                form.reportValidity();
            }
        });
    });
    
    // Share service function
    function shareService() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $service->title }}',
                text: '{{ $service->short_description }}',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('{{ __("Service URL copied to clipboard!") }}');
            });
        }
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush