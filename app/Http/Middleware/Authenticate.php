<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');
        if (!$request->expectsJson()) {
            if ($request->routeIs('admin.*')) {
                // if (auth('admin')->check()) Admin::findOrFail(auth('user')->id())->update(['is_online' => false]);
                session()->flash('fail', 'You must login first');
                return route('admin.login');
            }

            if ($request->routeIs('consignor.*')) {
                // if (auth('user')->check()) User::findOrFail(auth('user')->id())->update(['is_online' => false]);
                session()->flash('fail', 'You must login first');
                return route('consignor.login');
            }
        }
    }
}