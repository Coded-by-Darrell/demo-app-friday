<!-- resources/views/components/footer.blade.php -->
<!-- Tutorial #12: Subview/Include view implementation -->

<footer class="footer-custom">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title">{{ __('Innovations Solutions & Marketing') }}</h5>
                    <p class="footer-text">
                        {{ __('We help businesses transform their ideas into digital reality with cutting-edge solutions and creative marketing strategies.') }}
                    </p>
                    
                    <!-- Contact Info -->
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Innovation Street<br>Tech District, Batangas 4200, Philippines</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:+639123456789">+63 912 345 6789</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:hello@innovations-marketing.com">hello@innovations-marketing.com</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle">{{ __('Quick Links') }}</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                        <li><a href="{{ route('services.public') }}">{{ __('Services') }}</a></li>
                        <li><a href="{{ route('team.public') }}">{{ __('Our Team') }}</a></li>
                        <li><a href="{{ route('contact.create') }}">{{ __('Contact') }}</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Services -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle">{{ __('Our Services') }}</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('services.public', ['category' => 'web_development']) }}">{{ __('Web Development') }}</a></li>
                        <li><a href="{{ route('services.public', ['category' => 'mobile_app']) }}">{{ __('Mobile Apps') }}</a></li>
                        <li><a href="{{ route('services.public', ['category' => 'digital_marketing']) }}">{{ __('Digital Marketing') }}</a></li>
                        <li><a href="{{ route('services.public', ['category' => 'ui_ux_design']) }}">{{ __('UI/UX Design') }}</a></li>
                        <li><a href="{{ route('services.public', ['category' => 'ecommerce']) }}">{{ __('E-commerce') }}</a></li>
                        <li><a href="{{ route('services.public', ['category' => 'consulting']) }}">{{ __('Consulting') }}</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Newsletter & Social -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-section">
                    <h6 class="footer-subtitle">{{ __('Stay Connected') }}</h6>
                    <p class="footer-text small">
                        {{ __('Subscribe to our newsletter for updates and insights.') }}
                    </p>
                    
                    <!-- Newsletter Signup -->
                    <form class="newsletter-form" id="newsletterForm">
                        @csrf
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   placeholder="{{ __('Your email address') }}" 
                                   name="email"
                                   required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Social Media Links -->
                    <div class="social-media mt-4">
                        <h6 class="footer-subtitle">{{ __('Follow Us') }}</h6>
                        <div class="social-links">
                            <a href="https://facebook.com/innovations-marketing" target="_blank" rel="noopener" class="social-link facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/innovations_mktg" target="_blank" rel="noopener" class="social-link twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://linkedin.com/company/innovations-marketing" target="_blank" rel="noopener" class="social-link linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://instagram.com/innovations_marketing" target="_blank" rel="noopener" class="social-link instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://github.com/innovations-marketing" target="_blank" rel="noopener" class="social-link github">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Divider -->
        <hr class="footer-divider">
        
        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-bottom-links">
                    <a href="/privacy-policy">{{ __('Privacy Policy') }}</a>
                    <a href="/terms-of-service">{{ __('Terms of Service') }}</a>
                    <a href="/cookie-policy">{{ __('Cookie Policy') }}</a>
                    <a href="/sitemap">{{ __('Sitemap') }}</a>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-bottom-info">
                    <p class="mb-1">
                        &copy; {{ date('Y') }} {{ __('Innovations Solutions & Marketing') }}. 
                        {{ __('All rights reserved.') }}
                    </p>
                    <p class="mb-0 small text-muted">
                        {{ __('Made with') }} <i class="fas fa-heart text-danger"></i> {{ __('in Batangas, Philippines') }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Business Hours -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <div class="business-hours">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        {{ __('Business Hours') }}: 
                        {{ __('Mon-Fri 8:00 AM - 6:00 PM') }} | 
                        {{ __('Sat 9:00 AM - 2:00 PM') }} | 
                        {{ __('Sun Closed') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="{{ __('Back to Top') }}">
        <i class="fas fa-chevron-up"></i>
    </button>
</footer>

<style>
    .footer-custom {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: #ffffff;
        padding: 4rem 0 2rem;
        margin-top: auto;
        position: relative;
    }
    
    .footer-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    }
    
    .footer-title {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
    
    .footer-subtitle {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .footer-text {
        color: #b0b0b0;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .contact-info .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: #b0b0b0;
    }
    
    .contact-info .contact-item i {
        color: var(--primary-color);
        margin-top: 0.25rem;
        flex-shrink: 0;
    }
    
    .contact-info .contact-item a {
        color: #b0b0b0;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .contact-info .contact-item a:hover {
        color: var(--primary-color);
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 0.5rem;
    }
    
    .footer-links a {
        color: #b0b0b0;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
        position: relative;
    }
    
    .footer-links a:hover {
        color: var(--primary-color);
        transform: translateX(5px);
    }
    
    .footer-links a::before {
        content: '';
        position: absolute;
        left: -15px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 1px;
        background: var(--primary-color);
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .footer-links a:hover::before {
        opacity: 1;
    }
    
    .newsletter-form .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border-radius: 8px 0 0 8px;
    }
    
    .newsletter-form .form-control::placeholder {
        color: #b0b0b0;
    }
    
    .newsletter-form .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary-color);
        color: #ffffff;
        box-shadow: none;
    }
    
    .newsletter-form .btn {
        border-radius: 0 8px 8px 0;
        padding: 0.75rem 1rem;
        border: 1px solid var(--primary-color);
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        text-decoration: none;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .social-link:hover {
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .social-link.facebook:hover { background: #1877f2; }
    .social-link.twitter:hover { background: #1da1f2; }
    .social-link.linkedin:hover { background: #0077b5; }
    .social-link.instagram:hover { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .social-link.github:hover { background: #333333; }
    
    .footer-divider {
        border-color: rgba(255, 255, 255, 0.1);
        margin: 2rem 0 1.5rem;
    }
    
    .footer-bottom-links {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .footer-bottom-links a {
        color: #b0b0b0;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s ease;
    }
    
    .footer-bottom-links a:hover {
        color: var(--primary-color);
    }
    
    .footer-bottom-info {
        color: #b0b0b0;
        font-size: 0.875rem;
    }
    
    .business-hours {
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        margin-top: 1rem;
    }
    
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 4px 20px rgba(0, 122, 255, 0.3);
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        background: var(--dark-color);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 122, 255, 0.4);
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .footer-custom {
            padding: 3rem 0 1.5rem;
        }
        
        .footer-bottom-links {
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .footer-bottom-info {
            text-align: center !important;
        }
        
        .social-links {
            justify-content: center;
        }
        
        .back-to-top {
            bottom: 1rem;
            right: 1rem;
            width: 45px;
            height: 45px;
        }
        
        .business-hours {
            text-align: center;
        }
    }
    
    /* Animation for footer sections */
    .footer-section {
        animation: fadeInUp 0.6s ease-out;
    }
    
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
    
    /* Loading animation for newsletter */
    .newsletter-form.loading .btn {
        pointer-events: none;
    }
    
    .newsletter-form.loading .btn i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Newsletter form submission
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const email = form.querySelector('input[name="email"]').value;
                const button = form.querySelector('button');
                const icon = button.querySelector('i');
                
                // Add loading state
                form.classList.add('loading');
                icon.className = 'fas fa-spinner';
                
                // Simulate API call (replace with actual endpoint)
                setTimeout(() => {
                    form.classList.remove('loading');
                    icon.className = 'fas fa-check';
                    
                    // Show success message
                    showNotification('{{ __("Thank you for subscribing!") }}', 'success');
                    
                    // Reset form
                    form.reset();
                    
                    // Reset icon after 2 seconds
                    setTimeout(() => {
                        icon.className = 'fas fa-paper-plane';
                    }, 2000);
                }, 1000);
            });
        }
        
        // Back to top functionality
        const backToTopBtn = document.getElementById('backToTop');
        if (backToTopBtn) {
            // Show/hide button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });
            
            // Smooth scroll to top
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
        
        // Animate footer sections on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.footer-section').forEach(section => {
            observer.observe(section);
        });
    });
    
    // Utility function for notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
</script>