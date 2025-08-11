<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\SmsChannel;

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
        // Optionally bind the current tenant id for global resolver usage.
        // You may set this from middleware based on domain/subdomain/header.
        // Here we default to the authenticated user's tenant when available.
        $user = Auth::user();
        if ($user && isset($user->tenant_id)) {
            app()->instance('tenant.id', (int) $user->tenant_id);
        }

        // Register custom SMS channel
        Notification::extend('sms', function ($app) {
            return $app->make(SmsChannel::class);
        });
    }
}
