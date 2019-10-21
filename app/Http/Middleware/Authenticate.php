<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null $guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('get.logout', ['error' => 'Please login first']);
        }
        if (data_get(auth('admin')->user(), 'is_admin') != 1) {
            return redirect()->route('get.logout', ['error' => 'Not allow login']);
        }
        return $next($request);
    }
}
