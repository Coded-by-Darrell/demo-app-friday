<!-- resources/views/pagination/custom.blade.php -->
<!-- Tutorial #47: Pagination in Laravel - Custom pagination view -->

@if ($paginator->hasPages())
    <nav aria-label="{{ __('Pagination Navigation') }}" class="pagination-wrapper">
        <ul class="pagination pagination-lg justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">{{ __('Previous') }}</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">{{ __('Previous') }}</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span class="d-none d-sm-inline me-1">{{ __('Next') }}</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <span class="d-none d-sm-inline me-1">{{ __('Next') }}</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
        
        {{-- Pagination Information --}}
        <div class="pagination-info text-center mt-3">
            <p class="text-muted mb-0">
                {{ __('Showing') }}
                <span class="fw-bold">{{ $paginator->firstItem() }}</span>
                {{ __('to') }}
                <span class="fw-bold">{{ $paginator->lastItem() }}</span>
                {{ __('of') }}
                <span class="fw-bold">{{ $paginator->total() }}</span>
                {{ __('results') }}
            </p>
        </div>
        
        {{-- Quick Jump (for large datasets) --}}
        @if ($paginator->lastPage() > 10)
            <div class="pagination-jump text-center mt-3">
                <form method="GET" class="d-inline-flex align-items-center gap-2">
                    @foreach(request()->query() as $key => $value)
                        @if($key !== 'page')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <label for="page-jump" class="form-label mb-0 text-muted small">{{ __('Go to page:') }}</label>
                    <input type="number" 
                           id="page-jump"
                           name="page" 
                           class="form-control form-control-sm" 
                           style="width: 80px;"
                           min="1" 
                           max="{{ $paginator->lastPage() }}" 
                           value="{{ $paginator->currentPage() }}"
                           onchange="this.form.submit()">
                    <small class="text-muted">{{ __('of') }} {{ $paginator->lastPage() }}</small>
                </form>
            </div>
        @endif
    </nav>
@endif

<style>
    .pagination-wrapper {
        margin: 2rem 0;
    }
    
    .pagination {
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.5rem;
        --bs-pagination-font-size: 1rem;
        --bs-pagination-color: var(--dark-color);
        --bs-pagination-bg: #fff;
        --bs-pagination-border-color: var(--border-color);
        --bs-pagination-border-radius: 12px;
        --bs-pagination-hover-color: var(--primary-color);
        --bs-pagination-hover-bg: rgba(0, 122, 255, 0.1);
        --bs-pagination-hover-border-color: var(--primary-color);
        --bs-pagination-focus-color: var(--primary-color);
        --bs-pagination-focus-bg: var(--light-gray);
        --bs-pagination-focus-border-color: var(--primary-color);
        --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(0, 122, 255, 0.25);
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: var(--primary-color);
        --bs-pagination-active-border-color: var(--primary-color);
        --bs-pagination-disabled-color: var(--medium-gray);
        --bs-pagination-disabled-bg: #fff;
        --bs-pagination-disabled-border-color: var(--border-color);
    }
    
    .page-link {
        transition: all 0.2s ease;
        font-weight: 500;
        border-radius: 8px !important;
        margin: 0 2px;
    }
    
    .page-item.active .page-link {
        box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
        transform: translateY(-1px);
    }
    
    .page-link:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 122, 255, 0.2);
    }
    
    .pagination-info {
        color: var(--medium-gray);
        font-size: 0.9rem;
    }
    
    .pagination-jump .form-control {
        border-radius: 6px;
        border: 1px solid var(--border-color);
        text-align: center;
    }
    
    .pagination-jump .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(0, 122, 255, 0.1);
    }
    
    /* Mobile responsive */
    @media (max-width: 576px) {
        .pagination {
            --bs-pagination-padding-x: 0.5rem;
            --bs-pagination-padding-y: 0.375rem;
            --bs-pagination-font-size: 0.875rem;
        }
        
        .pagination-lg {
            --bs-pagination-padding-x: 0.75rem;
            --bs-pagination-padding-y: 0.5rem;
            --bs-pagination-font-size: 1rem;
        }
        
        .page-link {
            margin: 0 1px;
        }
        
        .pagination-jump {
            flex-direction: column;
            gap: 0.5rem !important;
        }
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .pagination {
            --bs-pagination-color: #f8f9fa;
            --bs-pagination-bg: #343a40;
            --bs-pagination-border-color: #495057;
            --bs-pagination-hover-bg: rgba(0, 122, 255, 0.2);
            --bs-pagination-focus-bg: #495057;
            --bs-pagination-disabled-bg: #343a40;
            --bs-pagination-disabled-border-color: #495057;
        }
        
        .pagination-info {
            color: #adb5bd;
        }
    }
    
    /* Animation for page transitions */
    .page-item {
        animation: fadeInScale 0.3s ease-out;
    }
    
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Loading state for pagination links */
    .page-link.loading {
        pointer-events: none;
        opacity: 0.6;