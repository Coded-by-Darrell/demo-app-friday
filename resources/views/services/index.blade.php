<!-- resources/views/services/index.blade.php -->
<!-- Tutorial #42: Get and display data from MySQL Table -->
<!-- Tutorial #46: Search data from MySQL Database Table -->
<!-- Tutorial #47: Pagination in Laravel -->

@extends('layouts.app')

@section('title', __('Our Services') . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 hero-content">
                <h1 class="hero-title">{{ __('Our Services') }}</h1>
                <p class="hero-subtitle">
                    {{ __('Discover our comprehensive range of digital solutions designed to help your business thrive in the modern marketplace.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('services.public') }}" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Search Input (Tutorial #46) -->
                                <div class="col-md-4">
                                    <label for="search" class="form-label">{{ __('Search Services') }}</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               id="search" 
                                               name="search" 
                                               value="{{ request('search') }}" 
                                               placeholder="{{ __('Enter keywords...') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Category Filter -->
                                <div class="col-md-3">
                                    <label for="category" class="form-label">{{ __('Category') }}</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="all">{{ __('All Categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" 
                                                    {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ Str::title(str_replace('_', ' ', $category)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Price Range Filter -->
                                <div class="col-md-3">
                                    <label for="price_range" class="form-label">{{ __('Price Range') }}</label>
                                    <select class="form-select" id="price_range" name="price_range">
                                        <option value="">{{ __('Any Price') }}</option>
                                        <option value="under_500" {{ request('price_range') == 'under_500' ? 'selected' : '' }}>
                                            {{ __('Under $500') }}
                                        </option>
                                        <option value="500_1000" {{ request('price_range') == '500_1000' ? 'selected' : '' }}>
                                            {{ __('$500 - $1,000') }}
                                        </option>
                                        <option value="1000_5000" {{ request('price_range') == '1000_5000' ? 'selected' : '' }}>
                                            {{ __('$1,000 - $5,000') }}
                                        </option>
                                        <option value="over_5000" {{ request('price_range') == 'over_5000' ? 'selected' : '' }}>
                                            {{ __('Over $5,000') }}
                                        </option>
                                    </select>
                                </div>
                                
                                <!-- Search Button -->
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i>
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Sort Options -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <label class="form-label mb-0 align-self-center">{{ __('Sort by:') }}</label>
                                        <select class="form-select form-select-sm" name="sort" style="width: auto;" onchange="this.form.submit()">
                                            <option value="sort_order" {{ request('sort') == 'sort_order' ? 'selected' : '' }}>
                                                {{ __('Default') }}
                                            </option>
                                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                                {{ __('Price: Low to High') }}
                                            </option>
                                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                                {{ __('Price: High to Low') }}
                                            </option>
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                                {{ __('Newest First') }}
                                            </option>
                                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                                {{ __('Most Popular') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Results Info -->
                                <div class="col-md-6 text-end">
                                    <p class="text-muted mb-0 align-self-center">
                                        {{ __('Showing :from-:to of :total results', [
                                            'from' => $services->firstItem() ?: 0,
                                            'to' => $services->lastItem() ?: 0,
                                            'total' => $services->total()
                                        ]) }}
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Services Grid (Tutorial #42: Display database data) -->
        @if($services->count() > 0)
            <div class="row g-4" id="servicesGrid">
                @foreach($services as $service)
                    <div class="col-md-6 col-lg-4 service-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Tutorial #13: Using service card component -->
                        <x-service-card :service="$service" />
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination (Tutorial #47) -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $services->withQueryString()->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        @else
            <!-- No Results State -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-search fa-4x text-muted"></i>
                        </div>
                        <h3 class="mb-3">{{ __('No Services Found') }}</h3>
                        <p class="text-muted mb-4">
                            @if(request()->hasAny(['search', 'category', 'price_range']))
                                {{ __('No services match your current filters. Try adjusting your search criteria.') }}
                            @else
                                {{ __('We are currently updating our services. Please check back soon.') }}
                            @endif
                        </p>
                        
                        @if(request()->hasAny(['search', 'category', 'price_range']))
                            <a href="{{ route('services.public') }}" class="btn btn-primary">
                                {{ __('View All Services') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Call to Action Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-primary text-white border-0">
                    <div class="card-body text-center py-5">
                        <h3 class="mb-3">{{ __('Need a Custom Solution?') }}</h3>
                        <p class="mb-4 lead">
                            {{ __('Can\'t find exactly what you\'re looking for? We create tailored solutions to meet your specific business needs.') }}
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('contact.create') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-envelope me-2"></i>
                                {{ __('Get Custom Quote') }}
                            </a>
                            <a href="tel:+639123456789" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-phone me-2"></i>
                                {{ __('Call Us Now') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Contact Modal -->
<div class="modal fade" id="quickContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Quick Contact') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickContactForm">
                    @csrf
                    <input type="hidden" name="service_id" id="modalServiceId">
                    
                    <div class="mb-3">
                        <label for="modalName" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="modalName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalEmail" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="modalEmail" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalMessage" class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control" id="modalMessage" name="message" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="sendQuickContact">{{ __('Send Message') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .service-item {
        transition: all 0.3s ease;
    }
    
    .filter-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .form-select:focus,
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
    }
    
    .search-results-info {
        background: rgba(0, 122, 255, 0.1);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
    }
    
    .filter-tags {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    
    .filter-tag {
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-tag:hover {
        background: var(--dark-color);
        color: white;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .loading-overlay.show {
        opacity: 1;
        visibility: visible;
    }
    
    /* Animation for service cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .service-item {
        animation: fadeInUp 0.6s ease-out;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .filter-section {
            padding: 1rem;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .btn-group-mobile {
            width: 100%;
        }
        
        .btn-group-mobile .btn {
            flex: 1;
        }
    }
</style>

<!-- AOS (Animate On Scroll) CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- AOS JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true,
            offset: 100
        });
        
        // Auto-submit form on filter change
        const filterSelects = document.querySelectorAll('#category, #price_range');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
        
        // Clear search functionality
        const clearSearchBtn = document.getElementById('clearSearch');
        const searchInput = document.getElementById('search');
        
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
        });
        
        // Real-time search with debouncing
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    document.getElementById('filterForm').submit();
                }
            }, 500);
        });
        
        // Quick contact modal functionality
        const quickContactBtns = document.querySelectorAll('.quick-contact-btn');
        const quickContactModal = new bootstrap.Modal(document.getElementById('quickContactModal'));
        
        quickContactBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const serviceId = this.dataset.serviceId;
                const serviceName = this.dataset.serviceName;
                
                document.getElementById('modalServiceId').value = serviceId;
                document.getElementById('modalMessage').value = `I'm interested in your ${serviceName} service. Please provide more information.`;
                
                quickContactModal.show();
            });
        });
        
        // Send quick contact form
        document.getElementById('sendQuickContact').addEventListener('click', function() {
            const form = document.getElementById('quickContactForm');
            const formData = new FormData(form);
            
            // Add loading state
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            
            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quickContactModal.hide();
                    showAlert('success', 'Message sent successfully!');
                    form.reset();
                } else {
                    showAlert('error', 'Failed to send message. Please try again.');
                }
            })
            .catch(error => {
                showAlert('error', 'An error occurred. Please try again.');
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '{{ __("Send Message") }}';
            });
        });
        
        // Show loading overlay during navigation
        const links = document.querySelectorAll('a[href*="services"]');
        links.forEach(link => {
            link.addEventListener('click', function() {
                if (!this.href.includes('#')) {
                    showLoadingOverlay();
                }
            });
        });
        
        // URL parameters management
        updateActiveFilters();
    });
    
    // Utility functions
    function showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay show';
        overlay.innerHTML = '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>';
        document.body.appendChild(overlay);
    }
    
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    function updateActiveFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        const filterContainer = document.querySelector('.filter-tags');
        
        if (filterContainer) {
            filterContainer.innerHTML = '';
            
            // Add active filter tags
            const filters = ['search', 'category', 'price_range'];
            filters.forEach(filter => {
                const value = urlParams.get(filter);
                if (value && value !== 'all' && value !== '') {
                    const tag = createFilterTag(filter, value);
                    filterContainer.appendChild(tag);
                }
            });
        }
    }
    
    function createFilterTag(type, value) {
        const tag = document.createElement('a');
        tag.className = 'filter-tag';
        tag.href = removeFilterFromURL(type);
        
        let label = value;
        if (type === 'category') {
            label = value.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        } else if (type === 'price_range') {
            const priceLabels = {
                'under_500': 'Under $500',
                '500_1000': '$500 - $1,000',
                '1000_5000': '$1,000 - $5,000',
                'over_5000': 'Over $5,000'
            };
            label = priceLabels[value] || value;
        }
        
        tag.innerHTML = `${label} <i class="fas fa-times"></i>`;
        return tag;
    }
    
    function removeFilterFromURL(filterToRemove) {
        const url = new URL(window.location);
        url.searchParams.delete(filterToRemove);
        return url.toString();
    }
</script>
@endpush