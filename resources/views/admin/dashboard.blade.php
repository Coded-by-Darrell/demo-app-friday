<!-- resources/views/admin/dashboard.blade.php -->
<!-- Tutorial #27: Display database data on UI -->
<!-- Tutorial #42: Get and display data from MySQL Table -->
<!-- Tutorial #36: Session in Laravel -->

@extends('layouts.app')

@section('title', __('Admin Dashboard') . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    {{ __('Admin Dashboard') }}
                </h1>
                <p class="mb-0 opacity-75">
                    {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="dashboard-actions">
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y - H:i') }}
                    </span>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        {{ __('View Site') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-xl-2">
            <div class="admin-sidebar">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <nav class="nav flex-column">
                            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home me-2"></i>
                                {{ __('Dashboard') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.services.index') }}">
                                <i class="fas fa-cogs me-2"></i>
                                {{ __('Services') }}
                                <span class="badge bg-primary ms-auto">{{ $stats['services']['total'] ?? 0 }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('admin.team.index') }}">
                                <i class="fas fa-users me-2"></i>
                                {{ __('Team Members') }}
                                <span class="badge bg-success ms-auto">{{ $stats['team']['active'] ?? 0 }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                                <i class="fas fa-envelope me-2"></i>
                                {{ __('Contact Messages') }}
                                @if(($stats['contacts']['unread'] ?? 0) > 0)
                                    <span class="badge bg-warning ms-auto">{{ $stats['contacts']['unread'] }}</span>
                                @endif
                            </a>
                            <div class="nav-divider"></div>
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-cog me-2"></i>
                                {{ __('Profile Settings') }}
                            </a>
                            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                {{ __('Logout') }}
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9 col-xl-10">
            <!-- Stats Cards (Tutorial #27: Display database data) -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary text-white rounded-3 me-3">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <h5 class="stat-number mb-0">{{ $stats['services']['total'] ?? 0 }}</h5>
                                    <p class="stat-label text-muted mb-0">{{ __('Total Services') }}</p>
                                </div>
                            </div>
                            <div class="stat-trend mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    {{ $stats['services']['active'] ?? 0 }} {{ __('active') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success text-white rounded-3 me-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h5 class="stat-number mb-0">{{ $stats['team']['total'] ?? 0 }}</h5>
                                    <p class="stat-label text-muted mb-0">{{ __('Team Members') }}</p>
                                </div>
                            </div>
                            <div class="stat-trend mt-2">
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ $stats['team']['active'] ?? 0 }} {{ __('active') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-warning text-white rounded-3 me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 class="stat-number mb-0">{{ $stats['contacts']['total'] ?? 0 }}</h5>
                                    <p class="stat-label text-muted mb-0">{{ __('Contact Messages') }}</p>
                                </div>
                            </div>
                            <div class="stat-trend mt-2">
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $stats['contacts']['unread'] ?? 0 }} {{ __('unread') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-info text-white rounded-3 me-3">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <h5 class="stat-number mb-0">{{ $stats['contacts']['today'] ?? 0 }}</h5>
                                    <p class="stat-label text-muted mb-0">{{ __('Today\'s Inquiries') }}</p>
                                </div>
                            </div>
                            <div class="stat-trend mt-2">
                                <small class="text-info">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ now()->format('M d') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Recent Contacts (Tutorial #42: Get and display data) -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    {{ __('Recent Contact Messages') }}
                                </h5>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('View All') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($recentContacts && $recentContacts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentContacts as $contact)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="contact-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                                {{ strtoupper(substr($contact->name, 0, 2)) }}
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $contact->name }}</div>
                                                                <small class="text-muted">{{ $contact->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="subject-text">{{ Str::limit($contact->subject, 30) }}</div>
                                                        @if($contact->company)
                                                            <small class="text-muted">{{ $contact->company }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $contact->status === 'unread' ? 'warning' : ($contact->status === 'read' ? 'info' : 'success') }}">
                                                            {{ ucfirst($contact->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small>{{ $contact->created_at->format('M d, H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact({{ $contact->id }})">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <a href="mailto:{{ $contact->email }}" class="btn btn-outline-success btn-sm">
                                                                <i class="fas fa-reply"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('No contact messages yet.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions & System Info -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt text-warning me-2"></i>
                                {{ __('Quick Actions') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    {{ __('Add New Service') }}
                                </a>
                                <a href="{{ route('admin.team.create') }}" class="btn btn-success">
                                    <i class="fas fa-user-plus me-2"></i>
                                    {{ __('Add Team Member') }}
                                </a>
                                <button class="btn btn-info" onclick="exportData()">
                                    <i class="fas fa-download me-2"></i>
                                    {{ __('Export Data') }}
                                </button>
                                <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" class="btn btn-warning">
                                    <i class="fas fa-envelope-open me-2"></i>
                                    {{ __('Review Messages') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Info -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                {{ __('System Information') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="system-info">
                                <div class="info-item">
                                    <span class="info-label">{{ __('Laravel Version') }}:</span>
                                    <span class="info-value">{{ app()->version() }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">{{ __('PHP Version') }}:</span>
                                    <span class="info-value">{{ phpversion() }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">{{ __('Server Time') }}:</span>
                                    <span class="info-value">{{ now()->format('H:i:s') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">{{ __('Environment') }}:</span>
                                    <span class="info-value badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">
                                        {{ ucfirst(app()->environment()) }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">{{ __('Debug Mode') }}:</span>
                                    <span class="info-value badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                                        {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">{{ __('Last Login') }}:</span>
                                    <span class="info-value">{{ auth()->user()->last_login_at?->diffForHumans() ?? 'First time' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Services -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-cogs text-primary me-2"></i>
                                    {{ __('Recent Services') }}
                                </h5>
                                <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('Manage All') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($recentServices && $recentServices->count() > 0)
                                <div class="row g-3">
                                    @foreach($recentServices as $service)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="service-mini-card">
                                                <div class="d-flex align-items-start">
                                                    @if($service->image_url)
                                                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="service-mini-image">
                                                    @else
                                                        <div class="service-mini-placeholder">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="service-mini-content">
                                                        <h6 class="service-mini-title">{{ Str::limit($service->title, 25) }}</h6>
                                                        <p class="service-mini-price">{{ $service->formatted_price }}</p>
                                                        <div class="service-mini-meta">
                                                            <span class="badge bg-{{ $service->status === 'active' ? 'success' : 'warning' }} badge-sm">
                                                                {{ ucfirst($service->status) }}
                                                            </span>
                                                            @if($service->featured)
                                                                <span class="badge bg-warning badge-sm">
                                                                    <i class="fas fa-star"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="service-mini-actions mt-2">
                                                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">{{ __('No services created yet.') }}</p>
                                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                                        {{ __('Create Your First Service') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact View Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Contact Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contactModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-success" id="replyToContact">
                    <i class="fas fa-reply me-1"></i>
                    {{ __('Reply') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection

@push('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #5856D6 100%);
    }
    
    .admin-sidebar .nav-link {
        color: #6c757d;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.25rem;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .admin-sidebar .nav-link:hover,
    .admin-sidebar .nav-link.active {
        color: var(--primary-color);
        background-color: rgba(0, 122, 255, 0.1);
    }
    
    .admin-sidebar .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: var(--primary-color);
        border-radius: 0 3px 3px 0;
    }
    
    .nav-divider {
        height: 1px;
        background: #e9ecef;
        margin: 0.5rem 1rem;
    }
    
    .stat-card {
        transition: transform 0.2s ease;
        border-left: 4px solid transparent;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .stat-card:nth-child(1) { border-left-color: var(--primary-color); }
    .stat-card:nth-child(2) { border-left-color: #28a745; }
    .stat-card:nth-child(3) { border-left-color: #ffc107; }
    .stat-card:nth-child(4) { border-left-color: #17a2b8; }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-color);
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .contact-avatar {
        font-weight: 600;
    }
    
    .subject-text {
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .service-mini-card {
        padding: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .service-mini-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .service-mini-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }
    
    .service-mini-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .service-mini-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--dark-color);
    }
    
    .service-mini-price {
        font-size: 0.8rem;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .service-mini-meta .badge-sm {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
    
    .service-mini-actions .btn {
        padding: 0.25rem 0.5rem;
        margin-right: 0.25rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 500;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.875rem;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .dashboard-header .row {
            text-align: center;
        }
        
        .dashboard-actions {
            margin-top: 1rem;
        }
        
        .stat-card {
            margin-bottom: 1rem;
        }
        
        .admin-sidebar {
            margin-bottom: 2rem;
        }
        
        .service-mini-card {
            margin-bottom: 1rem;
        }
    }
    
    /* Animation for cards */
    .card {
        animation: fadeInUp 0.5s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Table hover effects */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 122, 255, 0.05);
    }
    
    /* Loading states */
    .btn.loading {
        pointer-events: none;
        opacity: 0.6;
    }
    
    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time clock update
        updateClock();
        setInterval(updateClock, 1000);
        
        // Auto-refresh stats every 5 minutes
        setInterval(refreshStats, 300000);
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        const clockElement = document.querySelector('.info-value:last-of-type');
        if (clockElement && clockElement.textContent.includes(':')) {
            clockElement.textContent = timeString;
        }
    }
    
    function refreshStats() {
        fetch('{{ route("admin.dashboard") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.stats) {
                updateStatCards(data.stats);
            }
        })
        .catch(error => console.log('Stats refresh failed:', error));
    }
    
    function updateStatCards(stats) {
        // Update stat numbers with animation
        document.querySelectorAll('.stat-number').forEach((element, index) => {
            const newValue = Object.values(stats)[index]?.total || 0;
            animateNumber(element, parseInt(element.textContent), newValue);
        });
    }
    
    function animateNumber(element, start, end) {
        const duration = 1000;
        const step = (end - start) / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += step;
            if ((step > 0 && current >= end) || (step < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.round(current);
        }, 16);
    }
    
    function viewContact(contactId) {
        const modal = new bootstrap.Modal(document.getElementById('contactModal'));
        const modalBody = document.getElementById('contactModalBody');
        const replyBtn = document.getElementById('replyToContact');
        
        // Show loading
        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"></div></div>';
        modal.show();
        
        // Fetch contact details
        fetch(`/admin/contacts/${contactId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalBody.innerHTML = formatContactDetails(data.contact);
                    replyBtn.onclick = () => window.open(`mailto:${data.contact.email}?subject=Re: ${data.contact.subject}`);
                } else {
                    modalBody.innerHTML = '<div class="alert alert-danger">Failed to load contact details.</div>';
                }
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Error loading contact details.</div>';
            });
    }
    
    function formatContactDetails(contact) {
        return `
            <div class="contact-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> ${contact.name}
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong> <a href="mailto:${contact.email}">${contact.email}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Phone:</strong> ${contact.phone || 'Not provided'}
                    </div>
                    <div class="col-md-6">
                        <strong>Company:</strong> ${contact.company || 'Not provided'}
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Subject:</strong> ${contact.subject}
                </div>
                <div class="mb-3">
                    <strong>Message:</strong>
                    <div class="border p-3 rounded bg-light mt-2">${contact.message}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status:</strong> 
                        <span class="badge bg-${contact.status === 'unread' ? 'warning' : 'success'}">${contact.status}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Received:</strong> ${new Date(contact.created_at).toLocaleDateString()}
                    </div>
                </div>
            </div>
        `;
    }
    
    function exportData() {
        const btn = event.target;
        btn.classList.add('loading');
        btn.disabled = true;
        
        // Simulate export process
        setTimeout(() => {
            alert('Export functionality would be implemented here');
            btn.classList.remove('loading');
            btn.disabled = false;
        }, 2000);
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'n':
                    e.preventDefault();
                    window.location.href = '{{ route("admin.services.create") }}';
                    break;
                case 'm':
                    e.preventDefault();
                    window.location.href = '{{ route("admin.contacts.index") }}';
                    break;
            }
        }
    });
</script>
@endpush