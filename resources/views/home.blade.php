<!-- resources/views/home.blade.php -->
<!-- Tutorial #10: Views in Laravel -->
<!-- Tutorial #27: Display database data on UI -->
<!-- Tutorial #13: Components usage -->

@extends('layouts.app')

@section('title', __('Home') . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">
                    {{ __('Innovate.') }}<br>
                    {{ __('Create.') }}<br>
                    <span class="text-warning">{{ __('Succeed.') }}</span>
                </h1>
                <p class="hero-subtitle">
                    {{ __('We help businesses transform their ideas into digital reality with cutting-edge solutions and creative marketing strategies.') }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('services.public') }}" class="btn btn-primary btn-lg">
                        {{ __('Explore Services') }}
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('contact.create') }}" class="btn btn-outline-light btn-lg">
                        {{ __('Get Quote') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <img src="{{ asset('images/hero-illustration.svg') }}" 
                         alt="{{ __('Innovation Illustration') }}" 
                         class="img-fluid"
                         style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animated background elements -->
    <div class="hero-bg-elements">
        <div class="floating-element" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-element" style="top: 60%; right: 15%; animation-delay: 2s;"></div>
        <div class="floating-element" style="bottom: 20%; left: 20%; animation-delay: 4s;"></div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">{{ __('Why Choose Us?') }}</h2>
                <p class="lead text-muted">
                    {{ __('We combine innovation, expertise, and dedication to deliver exceptional results for your business.') }}
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-rocket fa-3x text-primary"></i>
                    </div>
                    <h4>{{ __('Fast Delivery') }}</h4>
                    <p class="text-muted">
                        {{ __('Quick turnaround times without compromising quality. We value your time and business needs.') }}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h4>{{ __('Expert Team') }}</h4>
                    <p class="text-muted">
                        {{ __('Our skilled professionals bring years of experience and cutting-edge expertise to every project.') }}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shield-alt fa-3x text-info"></i>
                    </div>
                    <h4>{{ __('Reliable Support') }}</h4>
                    <p class="text-muted">
                        {{ __('24/7 customer support and maintenance to ensure your success long after project completion.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Section (Tutorial #27: Display database data) -->
@if($featuredServices->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">{{ __('Featured Services') }}</h2>
                <p class="lead text-muted">
                    {{ __('Discover our most popular services that help businesses grow and succeed.') }}
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($featuredServices as $service)
                <div class="col-md-6 col-lg-4">
                    <!-- Tutorial #13: Using Components -->
                    <x-service-card :service="$service" />
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('services.public') }}" class="btn btn-outline-primary btn-lg">
                {{ __('View All Services') }}
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Team Section (Tutorial #27: Display database data) -->
@if($teamMembers->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">{{ __('Meet Our Team') }}</h2>
                <p class="lead text-muted">
                    {{ __('Our talented team of professionals is dedicated to bringing your vision to life.') }}
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($teamMembers as $member)
                <div class="col-md-6 col-lg-3">
                    <!-- Tutorial #13: Using Components -->
                    <x-team-member-card :member="$member" />
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('team.public') }}" class="btn btn-outline-primary btn-lg">
                {{ __('Meet Full Team') }}
                <i class="fas fa-users ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Statistics Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="24">0</h3>
                    <p class="mb-0">{{ __('Support Hours') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">{{ __('Ready to Start Your Project?') }}</h2>
                <p class="lead text-muted mb-4">
                    {{ __('Let\'s discuss how we can help transform your business with our innovative solutions.') }}
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('contact.create') }}" class="btn btn-primary btn-lg">
                        {{ __('Start Your Project') }}
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('services.public') }}" class="btn btn-outline-primary btn-lg">
                        {{ __('Learn More') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">{{ __('What Our Clients Say') }}</h2>
                <p class="lead text-muted">
                    {{ __('Don\'t just take our word for it. Here\'s what our satisfied clients have to say.') }}
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">
                        "{{ __('Innovations Solutions transformed our online presence completely. Their team is professional, creative, and delivers on time.') }}"
                    </p>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/client1.jpg') }}" alt="Client" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">CEO, TechStart Inc.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">
                        "{{ __('Outstanding service and support. They helped us increase our sales by 200% with their digital marketing strategies.') }}"
                    </p>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/client2.jpg') }}" alt="Client" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Founder, GrowFast</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-3">
                        "{{ __('Their innovative approach and attention to detail made all the difference. Highly recommended for any business.') }}"
                    </p>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/client3.jpg') }}" alt="Client" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0">Emily Rodriguez</h6>
                            <small class="text-muted">Director, Creative Hub</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero section animations */
    .floating-element {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    /* Feature icons hover effect */
    .feature-icon {
        transition: transform 0.3s ease;
    }
    
    .feature-icon:hover {
        transform: scale(1.1);
    }
    
    /* Counter animation */
    .counter {
        opacity: 0;
        transform: translateY(20px);
    }
    
    .counter.animated {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.6s ease;
    }
    
    /* Testimonial cards */
    .testimonial-card {
        transition: transform 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
    }
    
    /* Hero image animation */
    .hero-image img {
        animation: heroFloat 3s ease-in-out infinite;
    }
    
    @keyframes heroFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    let current = 0;
                    const increment = target / 100;
                    
                    counter.classList.add('animated');
                    
                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.ceil(current);
                            setTimeout(updateCounter, 20);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    
                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        });
        
        counters.forEach(counter => observer.observe(counter));
    }
    
    // Initialize animations when page loads
    document.addEventListener('DOMContentLoaded', function() {
        animateCounters();
    });
</script>
@endpushd counter" data-target="150">0</h3>
                    <p class="mb-0">{{ __('Projects Completed') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="50">0</h3>
                    <p class="mb-0">{{ __('Happy Clients') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="5">0</h3>
                    <p class="mb-0">{{ __('Years Experience') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bol