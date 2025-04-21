<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if ($guard == 'admin' && Auth::guard($guard)->check()) {
            return redirect('admin/home');
        }
        if ($guard == 'adopter' && Auth::guard($guard)->check()) {
            return redirect('adopter/home');
        }
        if ($guard == 'organization' && Auth::guard($guard)->check()) {
            return redirect('organization/home');
        }
        return $next($request);
    }
}
