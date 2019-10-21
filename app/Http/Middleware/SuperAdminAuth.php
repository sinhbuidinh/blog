<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth('admin')->check() && (data_get(auth('admin')->user(), 'is_admin') != 1 || !isSuperAdmin('admin'))) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
