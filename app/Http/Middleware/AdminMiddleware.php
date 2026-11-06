<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the admin area.');
        }

        if (!auth()->user()->is_admin) {
            ActivityLog::record(
                action: 'UNAUTHORIZED_ACCESS',
                description: 'User ' . auth()->user()->username . ' attempted to access admin area without permission.',
                user: auth()->user(),
                request: $request
            );

            abort(403, 'Access denied. You do not have administrator permissions.');
        }

        return $next($request);
    }
}
