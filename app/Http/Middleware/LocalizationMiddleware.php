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