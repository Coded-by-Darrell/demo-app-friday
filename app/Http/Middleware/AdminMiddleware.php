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





