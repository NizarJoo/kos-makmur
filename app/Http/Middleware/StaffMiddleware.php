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
                ->with('error', 'Silakan login untuk mengakses area ini.');
        }

        // If no roles specified → allow all authenticated users
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user role is allowed
        if (!in_array($user->role, $roles)) {
            // Redirect ke dashboard biasa, bukan staff dashboard
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses area ini.');
        }

        return $next($request);
    }
}
