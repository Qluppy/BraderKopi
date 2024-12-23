<?php

namespace App\Providers;

use Spatie\Dropbox\Client;
use App\Services\DropboxTokenProvider;
use Illuminate\Support\ServiceProvider;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(Client::class, function ($app) {
            $tokenProvider = new DropboxTokenProvider();
            return new Client($tokenProvider);
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
