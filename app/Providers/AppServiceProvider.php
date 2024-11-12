<?php

namespace App\Providers;

use App\Guards\QuickBookGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Vite;
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
        Http::macro('quickbookOAuth', function () {
            return Http::baseUrl(config('services.quickbook.auth_base_url'));
        });

        Http::macro('quickbookTokenUrl', function () {
            return Http::baseUrl(config('services.quickbook.token_base_url'));
        });

        Http::macro('quickbook', function () {
            // attach token
            return Http::baseUrl(config('services.quickbook.quick_book_base_url'))
                ->withHeaders([
                    'Accept' => 'application/json'
                ])
                ->withToken(Auth::guard('quickbook')->getQuickBookToken());
        });

        // register quickbook driver
        Auth::extend('quickbook', function ($app, $name, array $config) {
            return new QuickBookGuard(Auth::createUserProvider($config['provider']));
        });

        Vite::prefetch(concurrency: 3);
    }
}
