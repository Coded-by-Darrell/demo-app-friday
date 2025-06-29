<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware - Tutorial #23, #24, #25: Middleware implementation
 * 
 * This middleware demonstrates:
 * - Tutorial #23: What is Middleware in Laravel
 * - Tutorial #24: Middleware Group
 * - Tutorial #25: Assigning Middleware to Routes
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Tutorial #23: Middleware implementation
     * This middleware checks if the authenticated user has admin privileges
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required'
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Please login to access this area.');
        }

        // Check if user is admin
        if (!auth()->user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin access required'
                ], 403);
            }
            
            abort(403, 'This action is unauthorized.');
        }

        // Check if user account is active
        if (!auth()->user()->is_active) {
            auth()->logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated'
                ], 403);
            }
            
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        // Log admin access for security
        $this->logAdminAccess($request);

        return $next($request);
    }

    /**
     * Log admin access for security monitoring
     */
    private function logAdminAccess(Request $request): void
    {
        try {
            \Log::info('Admin access', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            // Fail silently to not interrupt the request
            \Log::error('Failed to log admin access: ' . $e->getMessage());
        }
    }
}

// app/Http/Middleware/ApiMiddleware.php
// Custom API middleware for enhanced security

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ApiMiddleware - Enhanced API security and logging
 */
class ApiMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set JSON response headers
        $request->headers->set('Accept', 'application/json');
        
        // Log API request
        $this->logApiRequest($request);
        
        // Check API rate limits (additional to Laravel's throttle)
        if ($this->isRateLimited($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => 60
            ], 429);
        }
        
        // Process request
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Log API response
        $this->logApiResponse($request, $response);
        
        return $response;
    }

    /**
     * Log API request for monitoring
     */
    private function logApiRequest(Request $request): void
    {
        try {
            \Log::channel('api')->info('API Request', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth('sanctum')->id(),
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log API request: ' . $e->getMessage());
        }
    }

    /**
     * Log API response for monitoring
     */
    private function logApiResponse(Request $request, Response $response): void
    {
        try {
            \Log::channel('api')->info('API Response', [
                'url' => $request->fullUrl(),
                'status_code' => $response->getStatusCode(),
                'response_time' => microtime(true) - LARAVEL_START,
                'user_id' => auth('sanctum')->id(),
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log API response: ' . $e->getMessage());
        }
    }

    /**
     * Check if request is rate limited
     */
    private function isRateLimited(Request $request): bool
    {
        $key = 'api_limit:' . $request->ip();
        $maxAttempts = 100; // per minute
        
        $attempts = cache()->get($key, 0);
        
        if ($attempts >= $maxAttempts) {
            return true;
        }
        
        cache()->put($key, $attempts + 1, 60);
        
        return false;
    }
}

// app/Http/Middleware/LocalizationMiddleware.php
// Tutorial #39-40: Localization middleware

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

/**
 * LocalizationMiddleware - Tutorial #39-40: Localization
 * 
 * This middleware handles language switching and localization
 */
class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, request, or default
        $locale = $this->getLocale($request);
        
        // Validate locale
        if (!in_array($locale, config('app.supported_locales', ['en', 'es']))) {
            $locale = config('app.locale', 'en');
        }
        
        // Set application locale
        App::setLocale($locale);
        
        // Store in session for future requests
        session(['locale' => $locale]);
        
        return $next($request);
    }

    /**
     * Get the locale from various sources
     */
    private function getLocale(Request $request): string
    {
        // 1. Check URL parameter
        if ($request->has('lang')) {
            return $request->get('lang');
        }
        
        // 2. Check session
        if (session()->has('locale')) {
            return session('locale');
        }
        
        // 3. Check user preference (if authenticated)
        if (auth()->check() && auth()->user()->locale) {
            return auth()->user()->locale;
        }
        
        // 4. Check Accept-Language header
        $acceptLanguage = $request->header('Accept-Language');
        if ($acceptLanguage) {
            $preferredLanguage = substr($acceptLanguage, 0, 2);
            if (in_array($preferredLanguage, ['en', 'es'])) {
                return $preferredLanguage;
            }
        }
        
        // 5. Default locale
        return config('app.locale', 'en');
    }
}

// app/Http/Middleware/SecurityHeadersMiddleware.php
// Additional security middleware

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeadersMiddleware - Enhanced security headers
 */
class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), camera=(), microphone=()');
        
        // HSTS header for HTTPS
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        // CSP header (basic)
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net cdnjs.cloudflare.com; " .
               "style-src 'self' 'unsafe-inline' fonts.googleapis.com cdn.jsdelivr.net; " .
               "font-src 'self' fonts.gstatic.com fonts.bunny.net; " .
               "img-src 'self' data: https:; " .
               "connect-src 'self' api.github.com;";
        
        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
}

// Register middleware in app/Http/Kernel.php (Tutorial #24: Middleware Groups)

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * Tutorial #24: Middleware Group implementation
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\SecurityHeadersMiddleware::class, // Custom security headers
    ];

    /**
     * The application's route middleware groups.
     * Tutorial #24: Middleware Groups
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LocalizationMiddleware::class, // Custom localization
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\ApiMiddleware::class, // Custom API middleware
        ],
    ];

    /**
     * The application's middleware aliases.
     * Tutorial #25: Assigning Middleware to Routes
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        
        // Custom middleware aliases
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Tutorial #25
        'localization' => \App\Http\Middleware\LocalizationMiddleware::class,
    ];
}