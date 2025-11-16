<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $role  Optional specific role check (admin, superadmin)
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this area.');
        }

        $user = Auth::user();

        // If specific role is required
        if ($role) {
            if ($user->role !== $role) {
                return redirect()->route('dashboard')
                    ->with('error', 'You do not have permission to access this area.');
            }
            return $next($request);
        }

        // Default: Check if user is staff (admin or superadmin)
        if (!$user->isStaff()) {
            return redirect()->route('dashboard')
                ->with('error', 'This area is restricted to staff members only.');
        }

        return $next($request);
    }
}