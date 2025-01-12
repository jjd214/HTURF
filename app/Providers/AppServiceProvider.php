<?php

namespace App\Providers;

use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Make Log Viewer available only to authorized users
        LogViewer::auth(function ($request) {
            // Example: Allow only users with 'admin' role to access the logs
            return $request->routeIs('admin.*');
        });
    }
}
