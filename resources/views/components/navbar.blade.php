<!-- resources/views/components/navbar.blade.php -->
<!-- Tutorial #12: Subview/Include view implementation -->
<!-- Tutorial #39-40: Localization with language switcher -->

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <strong>{{ __('Innovations') }}</strong> {{ __('Solutions') }}
        </a>
        
        <!-- Mobile toggle button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">
                        {{ __('Home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" 
                       href="{{ route('about') }}">
                        {{ __('About') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" 
                       href="{{ route('services.public') }}">
                        {{ __('Services') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}" 
                       href="{{ route('team.public') }}">
                        {{ __('Team') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" 
                       href="{{ route('contact.create') }}">
                        {{ __('Contact') }}
                    </a>
                </li>
            </ul>
            
            <!-- Right side navigation -->
            <ul class="navbar-nav ms-auto">
                <!-- Language Switcher (Tutorial #39-40) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-globe"></i>
                        @if(app()->getLocale() == 'en')
                            {{ __('English') }}
                        @elseif(app()->getLocale() == 'es')
                            {{ __('Español') }}
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" 
                               href="{{ route('lang.switch', 'en') }}">
                                🇺🇸 English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'es' ? 'active' : '' }}" 
                               href="{{ route('lang.switch', 'es') }}">
                                🇪🇸 Español
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('register') }}">
                            {{ __('Get Started') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i>
                                    {{ __('Profile') }}
                                </a>
                            </li>
                            
                            @if(Auth::user()->is_admin)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <h6 class="dropdown-header">{{ __('Administration') }}</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.services.index') }}">
                                        <i class="fas fa-cogs me-2"></i>
                                        {{ __('Manage Services') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.team.index') }}">
                                        <i class="fas fa-users me-2"></i>
                                        {{ __('Manage Team') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.contacts.index') }}">
                                        <i class="fas fa-envelope me-2"></i>
                                        {{ __('View Contacts') }}
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Add some top margin to body content since navbar is fixed -->
<style>
    body {
        padding-top: 80px;
    }
    
    .navbar-custom .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
    }
    
    .navbar-custom .dropdown-item {
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .navbar-custom .dropdown-item:hover {
        background-color: rgba(0, 122, 255, 0.1);
        color: var(--primary-color);
    }
    
    .navbar-custom .dropdown-item.active {
        background-color: var(--primary-color);
        color: white;
    }
    
    .navbar-custom .dropdown-header {
        color: var(--medium-gray);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.5rem 1rem 0.25rem;
    }
    
    .navbar-toggler {
        border: none !important;
        padding: 0.25rem 0.5rem;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2829, 29, 31, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    @media (max-width: 991px) {
        .navbar-nav .nav-link {
            text-align: center;
            padding: 0.75rem 1rem !important;
        }
        
        .navbar-nav .btn {
            margin: 0.5rem auto;
            display: block;
            width: fit-content;
        }
    }
</style>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">