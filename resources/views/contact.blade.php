<!-- resources/views/contact.blade.php -->
<!-- Tutorial #14: Input fields and form submit -->
<!-- Tutorial #15: Form handling with checkbox, radio button and dropdown -->
<!-- Tutorial #16: Form Validation -->
<!-- Tutorial #17: Custom Validation Messages -->
<!-- Tutorial #64: Send Email -->

@extends('layouts.app')

@section('title', __('Contact Us') . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">{{ __('Get In Touch') }}</h1>
                <p class="hero-subtitle">
                    {{ __('Ready to start your next project? Let\'s discuss how we can help you achieve your goals.') }}
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-4 mb-5">
                <div class="contact-info">
                    <h3 class="mb-4">{{ __('Contact Information') }}</h3>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ __('Office Address') }}</h6>
                                <p class="text-muted mb-0">
                                    123 Innovation Street<br>
                                    Tech District, Batangas 4200<br>
                                    Philippines
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ __('Phone Number') }}</h6>
                                <p class="text-muted mb-0">
                                    <a href="tel:+639123456789" class="text-decoration-none">
                                        +63 912 345 6789
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ __('Email Address') }}</h6>
                                <p class="text-muted mb-0">
                                    <a href="mailto:hello@innovations-marketing.com" class="text-decoration-none">
                                        hello@innovations-marketing.com
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="fas fa-clock fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ __('Business Hours') }}</h6>
                                <p class="text-muted mb-0">
                                    {{ __('Monday - Friday: 8:00 AM - 6:00 PM') }}<br>
                                    {{ __('Saturday: 9:00 AM - 2:00 PM') }}<br>
                                    {{ __('Sunday: Closed') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="social-links mt-4">
                        <h6 class="mb-3">{{ __('Follow Us') }}</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-wrapper">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <h3 class="mb-4">{{ __('Send us a Message') }}</h3>
                            <p class="text-muted mb-4">
                                {{ __('Fill out the form below and we\'ll get back to you within 24 hours.') }}
                            </p>
                            
                            <!-- Tutorial #14: Form with CSRF protection -->
                            <form method="POST" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                                @csrf
                                
                                <div class="row">
                                    <!-- Name Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">
                                            {{ __('Full Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Email Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">
                                            {{ __('Email Address') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <!-- Phone Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                        <input type="tel" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Company Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">{{ __('Company Name') }}</label>
                                        <input type="text" 
                                               class="form-control @error('company') is-invalid @enderror" 
                                               id="company" 
                                               name="company" 
                                               value="{{ old('company') }}">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Subject Field -->
                                <div class="mb-3">
                                    <label for="subject" class="form-label">
                                        {{ __('Subject') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" 
                                           name="subject" 
                                           value="{{ old('subject') }}" 
                                           required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Tutorial #15: Checkbox for services interest -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Services of Interest') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="service_interest[]" 
                                                       value="branding" 
                                                       id="branding"
                                                       {{ in_array('branding', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="branding">
                                                    {{ __('Branding & Design') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="service_interest[]" 
                                                       value="consulting" 
                                                       id="consulting"
                                                       {{ in_array('consulting', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="consulting">
                                                    {{ __('Business Consulting') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tutorial #15: Dropdown for budget range -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="budget_range" class="form-label">{{ __('Budget Range') }}</label>
                                        <select class="form-select @error('budget_range') is-invalid @enderror" 
                                                id="budget_range" 
                                                name="budget_range">
                                            <option value="">{{ __('Select Budget Range') }}</option>
                                            <option value="under_5k" {{ old('budget_range') == 'under_5k' ? 'selected' : '' }}>
                                                {{ __('Under $5,000') }}
                                            </option>
                                            <option value="5k_10k" {{ old('budget_range') == '5k_10k' ? 'selected' : '' }}>
                                                {{ __('$5,000 - $10,000') }}
                                            </option>
                                            <option value="10k_25k" {{ old('budget_range') == '10k_25k' ? 'selected' : '' }}>
                                                {{ __('$10,000 - $25,000') }}
                                            </option>
                                            <option value="25k_50k" {{ old('budget_range') == '25k_50k' ? 'selected' : '' }}>
                                                {{ __('$25,000 - $50,000') }}
                                            </option>
                                            <option value="over_50k" {{ old('budget_range') == 'over_50k' ? 'selected' : '' }}>
                                                {{ __('Over $50,000') }}
                                            </option>
                                        </select>
                                        @error('budget_range')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Tutorial #15: Radio buttons for preferred contact method -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            {{ __('Preferred Contact Method') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input @error('preferred_contact') is-invalid @enderror" 
                                                       type="radio" 
                                                       name="preferred_contact" 
                                                       value="email" 
                                                       id="contact_email"
                                                       {{ old('preferred_contact', 'email') == 'email' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="contact_email">
                                                    {{ __('Email') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('preferred_contact') is-invalid @enderror" 
                                                       type="radio" 
                                                       name="preferred_contact" 
                                                       value="phone" 
                                                       id="contact_phone"
                                                       {{ old('preferred_contact') == 'phone' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="contact_phone">
                                                    {{ __('Phone') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('preferred_contact') is-invalid @enderror" 
                                                       type="radio" 
                                                       name="preferred_contact" 
                                                       value="either" 
                                                       id="contact_either"
                                                       {{ old('preferred_contact') == 'either' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="contact_either">
                                                    {{ __('Either') }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('preferred_contact')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Message Field -->
                                <div class="mb-4">
                                    <label for="message" class="form-label">
                                        {{ __('Message') }} <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              placeholder="{{ __('Tell us about your project...') }}" 
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        {{ __('Minimum 10 characters required') }}
                                    </div>
                                </div>
                                
                                <!-- Privacy Agreement -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="privacy_agreement" 
                                               name="privacy_agreement" 
                                               required>
                                        <label class="form-check-label" for="privacy_agreement">
                                            {{ __('I agree to the') }} 
                                            <a href="#" class="text-primary">{{ __('Privacy Policy') }}</a> 
                                            {{ __('and') }} 
                                            <a href="#" class="text-primary">{{ __('Terms of Service') }}</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        {{ __('Send Message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-4">{{ __('Find Us') }}</h3>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123456.789!2d121.0583!3d13.7565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQ1JzIzLjQiTiAxMjHCsDAzJzI5LjkiRQ!5e0!3m2!1sen!2sph!4v1640000000000!5m2!1sen!2sph" 
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 12px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .contact-info {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    
    .contact-item {
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    
    .contact-item:hover {
        background-color: var(--light-gray);
        transform: translateX(5px);
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(0, 122, 255, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .social-link:hover {
        background: var(--dark-color);
        color: white;
        transform: translateY(-2px);
    }
    
    .contact-form-wrapper .card {
        border-radius: 16px;
        overflow: hidden;
    }
    
    .form-control, .form-select {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 16px;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
    }
    
    .form-check-input {
        border-radius: 4px;
        border: 2px solid #dee2e6;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .form-check-input[type="radio"] {
        border-radius: 50%;
    }
    
    .form-label {
        font-weight: 500;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .form-text {
        color: var(--medium-gray);
        font-size: 0.875rem;
    }
    
    .map-container {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }
    
    /* Form validation styles */
    .was-validated .form-control:valid,
    .form-control.is-valid {
        border-color: var(--success-color);
    }
    
    .was-validated .form-control:invalid,
    .form-control.is-invalid {
        border-color: var(--danger-color);
    }
    
    /* Loading state for submit button */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }
    
    .btn-loading::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    .btn-loading .fas {
        opacity: 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .contact-info {
            position: static;
            margin-bottom: 2rem;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .card-body {
            padding: 2rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        
        // Form validation
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                // Add loading state to submit button
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> {{ __("Sending...") }}';
            }
            
            form.classList.add('was-validated');
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });
        
        // Character counter for message field
        const messageField = document.getElementById('message');
        const messageHelp = messageField.nextElementSibling;
        
        messageField.addEventListener('input', function() {
            const currentLength = this.value.length;
            const minLength = 10;
            
            if (currentLength < minLength) {
                messageHelp.textContent = `{{ __('Minimum 10 characters required') }} (${currentLength}/${minLength})`;
                messageHelp.style.color = 'var(--danger-color)';
            } else {
                messageHelp.textContent = `{{ __('Character count') }}: ${currentLength}`;
                messageHelp.style.color = 'var(--success-color)';
            }
        });
        
        // Auto-resize textarea
        messageField.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Phone number formatting
        const phoneField = document.getElementById('phone');
        phoneField.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('63')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+63' + value.substring(1);
            } else if (value.length > 0 && !value.startsWith('+')) {
                value = '+63' + value;
            }
            this.value = value;
        });
    });
</script>
@endpush" 
                                                       name="service_interest[]" 
                                                       value="web_development" 
                                                       id="web_dev"
                                                       {{ in_array('web_development', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="web_dev">
                                                    {{ __('Web Development') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="service_interest[]" 
                                                       value="mobile_app" 
                                                       id="mobile_app"
                                                       {{ in_array('mobile_app', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mobile_app">
                                                    {{ __('Mobile App Development') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="service_interest[]" 
                                                       value="digital_marketing" 
                                                       id="digital_marketing"
                                                       {{ in_array('digital_marketing', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="digital_marketing">
                                                    {{ __('Digital Marketing') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="service_interest[]" 
                                                       value="seo" 
                                                       id="seo"
                                                       {{ in_array('seo', old('service_interest', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seo">
                                                    {{ __('SEO Optimization') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox