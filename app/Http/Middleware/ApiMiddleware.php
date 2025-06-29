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