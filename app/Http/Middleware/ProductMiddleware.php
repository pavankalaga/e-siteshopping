<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            if (auth('api')->check()) {
                return $next($request);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        if (auth()->check()) {
            return $next($request);
        }
    
        return redirect()->route('form')->with('error', 'Login For Access');
    }
}
