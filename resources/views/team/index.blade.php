<!-- resources/views/team/index.blade.php -->
<!-- Tutorial #27: Display database data on UI -->
<!-- Tutorial #42: Get and display data from MySQL Table -->

@extends('layouts.app')

@section('title', __('Our Team') . ' - Innovations Solutions & Marketing')

@section('content')
<!-- Hero Section -->
<section class="team-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">{{ __('Meet Our Amazing Team') }}</h1>
                <p class="hero-subtitle">
                    {{ __('Talented professionals dedicated to bringing your vision to life with creativity, expertise, and passion.') }}
                </p>
                <div class="team-stats d-flex gap-4 flex-wrap">
                    <div class="stat-item">
                        <h3 class="stat-number">{{ $teamMembers->count() }}</h3>
                        <p class="stat-label">{{ __('Team Members') }}</p>
                    </div>
                    <div class="stat-item">
                        <h3 class="stat-number">{{ $teamMembers->groupBy('department')->count() }}</h3>
                        <p class="stat-label">{{ __('Departments') }}</p>
                    </div>
                    <div class="stat-item">
                        <h3 class="stat-number">{{ $teamMembers->sum(function($member) { return $member->hire_date ? now()->diffInYears($member->hire_date) : 5; }) }}</h3>
                        <p class="stat-label">{{ __('Years Experience') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="team-hero-image">
                    <img src="{{ asset('images/team-hero.svg') }}" alt="{{ __('Team Illustration') }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Members Section (Tutorial #42: Display database data) -->
<section class="py-5">
    <div class="container">
        <!-- Department Filter -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="department-filter">
                    <button class="filter-btn active" data-department="all">
                        {{ __('All Team') }}
                    </button>
                    @foreach($teamMembers->groupBy('department') as $department => $members)
                        <button class="filter-btn" data-department="{{ Str::slug($department) }}">
                            {{ ucfirst($department) }}
                            <span class="member-count">({{ $members->count() }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Team Grid -->
        <div class="team-grid" id="teamGrid">
            @foreach($teamMembers as $member)
                <div class="team-member-card" data-department="{{ Str::slug($member->department) }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="member-card-inner">
                        <!-- Member Image -->
                        <div class="member-image-container">
                            @if($member->image)
                                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="member-image">
                            @else
                                <div class="member-image-placeholder">
                                    <span class="member-initials">{{ $member->initials }}</span>
                                </div>
                            @endif
                            
                            <!-- Social Links Overlay -->
                            <div class="member-social-overlay">
                                <div class="social-links">
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}" class="social-link email" title="{{ __('Send Email') }}">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    @endif
                                    @if($member->linkedin)
                                        <a href="{{ $member->linkedin }}" target="_blank" class="social-link linkedin" title="{{ __('LinkedIn Profile') }}">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif
                                    @if($member->twitter)
                                        <a href="{{ $member->twitter }}" target="_blank" class="social-link twitter" title="{{ __('Twitter Profile') }}">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if($member->github)
                                        <a href="{{ $member->github }}" target="_blank" class="social-link github" title="{{ __('GitHub Profile') }}">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Member Info -->
                        <div class="member-info">
                            <h4 class="member-name">{{ $member->name }}</h4>
                            <p class="member-position">{{ $member->position }}</p>
                            <p class="member-department">{{ ucfirst($member->department) }}</p>
                            
                            @if($member->bio)
                                <p class="member-bio">{{ Str::limit($member->bio, 120) }}</p>
                            @endif
                            
                            <!-- Skills -->
                            @if($member->skills && count($member->skills) > 0)
                                <div class="member-skills">
                                    @foreach(array_slice($member->skills, 0, 3) as $skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($member->skills) > 3)
                                        <span class="skill-tag more">+{{ count($member->skills) - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Contact Button -->
                            <div class="member-actions mt-3">
                                <button class="btn btn-outline-primary btn-sm" onclick="contactMember('{{ $member->name }}', '{{ $member->email }}')">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ __('Contact') }}
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="viewMember({{ $member->id }})">
                                    <i class="fas fa-user me-1"></i>
                                    {{ __('View Profile') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Join Our Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">{{ __('Want to Join Our Team?') }}</h2>
                <p class="lead text-muted mb-4">
                    {{ __('We\'re always looking for talented individuals who are passionate about innovation and excellence. Join us in creating amazing digital experiences.') }}
                </p>
                
                <div class="join-benefits row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <i class="fas fa-laptop-code fa-2x text-primary mb-3"></i>
                            <h5>{{ __('Remote Friendly') }}</h5>
                            <p class="text-muted">{{ __('Work from anywhere with flexible hours and modern tools.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <i class="fas fa-graduation-cap fa-2x text-success mb-3"></i>
                            <h5>{{ __('Growth Opportunities') }}</h5>
                            <p class="text-muted">{{ __('Continuous learning and career development programs.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <i class="fas fa-heart fa-2x text-danger mb-3"></i>
                            <h5>{{ __('Great Culture') }}</h5>
                            <p class="text-muted">{{ __('Collaborative environment with amazing colleagues.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('contact.create', ['subject' => 'Career Opportunity']) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-briefcase me-2"></i>
                        {{ __('View Open Positions') }}
                    </a>
                    <a href="mailto:careers@innovations-marketing.com" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        {{ __('Send Your Resume') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Member Profile Modal -->
<div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="memberModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Member Modal -->
<div class="modal fade" id="contactMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Contact Team Member') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="contactMemberForm">
                    @csrf
                    <input type="hidden" id="memberName" name="member_name">
                    <input type="hidden" id="memberEmail" name="member_email">
                    
                    <div class="mb-3">
                        <label for="yourName" class="form-label">{{ __('Your Name') }}</label>
                        <input type="text" class="form-control" id="contactSubject" name="subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control" id="contactMessage" name="message" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="sendMemberContact()">
                    <i class="fas fa-paper-plane me-1"></i>
                    {{ __('Send Message') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- AOS (Animate On Scroll) CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    .team-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 5rem 0;
        overflow: hidden;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--medium-gray);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .team-stats .stat-item {
        text-align: center;
    }
    
    .team-stats .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .team-stats .stat-label {
        font-size: 0.9rem;
        color: var(--medium-gray);
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .team-hero-image img {
        max-height: 400px;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .department-filter {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
    
    .filter-btn {
        background: white;
        border: 2px solid var(--border-color);
        color: var(--dark-color);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
    }
    
    .member-count {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .team-member-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        opacity: 1;
        transform: scale(1);
    }
    
    .team-member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .team-member-card.hidden {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }
    
    .member-card-inner {
        position: relative;
        height: 100%;
    }
    
    .member-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .member-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .member-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color), #5856D6);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .member-initials {
        font-size: 3rem;
        font-weight: 700;
        color: white;
    }
    
    .member-social-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .team-member-card:hover .member-social-overlay {
        opacity: 1;
    }
    
    .team-member-card:hover .member-image {
        transform: scale(1.1);
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
    }
    
    .social-link {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .social-link:hover {
        color: white;
        transform: scale(1.1);
    }
    
    .social-link.email:hover { background: #EA4335; }
    .social-link.linkedin:hover { background: #0077B5; }
    .social-link.twitter:hover { background: #1DA1F2; }
    .social-link.github:hover { background: #333; }
    
    .member-info {
        padding: 1.5rem;
    }
    
    .member-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }
    
    .member-position {
        font-size: 1rem;
        font-weight: 500;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
    }
    
    .member-department {
        font-size: 0.875rem;
        color: var(--medium-gray);
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .member-bio {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .member-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .skill-tag {
        background: rgba(0, 122, 255, 0.1);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .skill-tag.more {
        background: var(--light-gray);
        color: var(--medium-gray);
    }
    
    .member-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .member-actions .btn {
        flex: 1;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .member-actions .btn:hover {
        transform: translateY(-1px);
    }
    
    .benefit-item {
        text-align: center;
        padding: 1.5rem;
    }
    
    .benefit-item h5 {
        color: var(--dark-color);
        margin-bottom: 0.75rem;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .team-stats {
            justify-content: center;
            text-align: center;
        }
        
        .team-stats .stat-item {
            min-width: 120px;
        }
        
        .department-filter {
            gap: 0.5rem;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .team-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .member-actions {
            flex-direction: column;
        }
    }
    
    /* Animation classes */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    .slide-in {
        animation: slideIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
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
        
        // Department filtering
        const filterBtns = document.querySelectorAll('.filter-btn');
        const memberCards = document.querySelectorAll('.team-member-card');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const department = this.dataset.department;
                
                // Update active button
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Filter cards
                filterMembers(department);
            });
        });
        
        function filterMembers(department) {
            memberCards.forEach(card => {
                const cardDepartment = card.dataset.department;
                
                if (department === 'all' || cardDepartment === department) {
                    card.classList.remove('hidden');
                    card.classList.add('fade-in');
                } else {
                    card.classList.add('hidden');
                    card.classList.remove('fade-in');
                }
            });
        }
        
        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        const statsSection = document.querySelector('.team-stats');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
        
        function animateStats() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const finalValue = parseInt(stat.textContent);
                animateNumber(stat, 0, finalValue, 2000);
            });
        }
        
        function animateNumber(element, start, end, duration) {
            const step = (end - start) / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= end) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = Math.round(current);
            }, 16);
        }
    });
    
    function contactMember(name, email) {
        document.getElementById('memberName').value = name;
        document.getElementById('memberEmail').value = email;
        document.getElementById('contactSubject').value = `Question about ${name}'s expertise`;
        
        const modal = new bootstrap.Modal(document.getElementById('contactMemberModal'));
        modal.show();
    }
    
    function sendMemberContact() {
        const form = document.getElementById('contactMemberForm');
        const formData = new FormData(form);
        
        // Here you would send the data to your backend
        // For demo purposes, we'll just show a success message
        alert('{{ __("Message sent successfully!") }}');
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('contactMemberModal'));
        modal.hide();
        form.reset();
    }
    
    function viewMember(memberId) {
        const modal = new bootstrap.Modal(document.getElementById('memberModal'));
        const modalBody = document.getElementById('memberModalBody');
        
        // Show loading
        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"></div></div>';
        modal.show();
        
        // Simulate loading member details
        setTimeout(() => {
            modalBody.innerHTML = `
                <div class="text-center py-4">
                    <h4>{{ __('Member Profile') }}</h4>
                    <p class="text-muted">{{ __('Detailed member profile would be loaded here.') }}</p>
                    <div class="alert alert-info">
                        {{ __('This would show detailed information about the team member, including their full bio, project history, and contact details.') }}
                    </div>
                </div>
            `;
        }, 1000);
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key >= '1' && e.key <= '9') {
            const index = parseInt(e.key) - 1;
            const filterBtns = document.querySelectorAll('.filter-btn');
            if (filterBtns[index]) {
                filterBtns[index].click();
            }
        }
    });
    
    // Smooth scroll for internal links
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
@endpushcontrol" id="yourName" name="your_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="yourEmail" class="form-label">{{ __('Your Email') }}</label>
                        <input type="email" class="form-control" id="yourEmail" name="your_email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contactSubject" class="form-label">{{ __('Subject') }}</label>
                        <input type="text" class="form-