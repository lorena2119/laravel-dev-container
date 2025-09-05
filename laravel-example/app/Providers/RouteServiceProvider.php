<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function(Request $request){
            if ($userId = optional($request->user())->getAuthIdentifier()) {
                return Limit::perMinute(100)->by('uid:' . $userId);
            }

            return Limit::perMinute(3)->by('ip:' . $request->ip());
        });
    }
}
