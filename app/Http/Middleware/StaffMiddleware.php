<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Example usage:
     * - role:admin
     * - role:admin,superadmin
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // User must be logged in
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this area.');
        }

        // If no roles specified → allow all authenticated users
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user role is allowed
        if (!in_array($user->role, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
