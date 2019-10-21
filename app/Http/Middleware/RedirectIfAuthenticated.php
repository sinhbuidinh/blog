<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (auth('admin')->check()) {
            if (data_get(auth('admin')->user(), 'is_admin') == 1) {
                return redirect('/admin/dashboard');
            }
            return redirect()->route('get.logout', ['error' => 'Permission denied']);
        }

        return $next($request);
    }
}
