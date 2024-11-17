<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictMultipleLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && $request->routeIs('consignor.*')) {
            return redirect()->route('admin.home')->with('fail', 'You are already logged in as Admin.');
        }

        if (Auth::guard('user')->check() && $request->routeIs('admin.*')) {
            return redirect()->route('consignor.home')->with('fail', 'You are already logged in as User.');
        }

        return $next($request);
    }
}
