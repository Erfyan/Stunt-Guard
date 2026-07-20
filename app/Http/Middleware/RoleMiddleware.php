<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $allowedRoles = collect($roles)
            ->flatMap(function ($role) {
                return explode(',', $role);
            })
            ->map(function ($role) {
                return trim($role);
            })
            ->filter()
            ->all();

        if (!in_array(Auth::user()->role, $allowedRoles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}