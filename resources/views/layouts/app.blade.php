<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Innovations Solutions & Marketing')</title>
    
    <!-- Apple-inspired favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Fonts - Apple-style typography -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 (Tutorial #51) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS (Tutorial #52) -->
    <style>
        :root {
            --primary-color: #007AFF;
            --secondary-color: #5856D6;
            --success-color: #34C759;
            --warning-color: #FF9500;
            --danger-color: #FF3B30;
            --dark-color: #1D1D1F;
            --light-gray: #F5F5F7;
            --medium-gray: #86868B;
            --border-color: #D2D2D7;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #fff;
        }
        
        /* Apple-style Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--dark-color) !important;
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 400;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(0, 122, 255, 0.1);
        }
        
        /* Apple-style buttons */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #0056B3;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 122, 255, 0.3);
        }
        
        .btn-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 122, 255, 0.3);
        }
        
        /* Hero section styling */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 60vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Card styling */
        .card-custom {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .card-custom:hover .card-img-top {
            transform: scale(1.05);
        }
        
        /* Footer styling */
        .footer-custom {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
        .footer-links a {
            color: var(--medium-gray);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        /* Language switcher */
        .language-switcher {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .language-switcher a {
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .language-switcher a:hover {
            background: rgba(0, 122, 255, 0.1);
        }
        
        /* Form styling */
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .navbar-nav {
                text-align: center;
                padding-top: 1rem;
            }
        }
        
        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Flash messages */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: rgba(52, 199, 89, 0.1);
            color: #1B6B04;
            border-left: 4px solid var(--success-color);
        }
        
        .alert-danger {
            background: rgba(255, 59, 48, 0.1);
            color: #D70015;
            border-left: 4px solid var(--danger-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation (Tutorial #12 - Include subview) -->
    @include('components.navbar')
    
    <!-- Flash Messages (Tutorial #37) -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    
    <!-- Main Content (Tutorial #53 - Template Inheritance) -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer (Tutorial #12 - Include subview) -->
    @include('components.footer')
    
    <!-- Bootstrap JS (Tutorial #52) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript (Tutorial #52) -->
    <script>
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
        
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.8)';
                navbar.style.boxShadow = 'none';
            }
        });
        
        // Form submission loading state
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                }
            });
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    bootstrap.Alert.getOrCreateInstance(alert).close();
                }
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>