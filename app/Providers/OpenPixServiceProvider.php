<?php

namespace App\Providers;

use OpenPix\PhpSdk\Client;
use Illuminate\Support\ServiceProvider;

class OpenPixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            $appId = config('services.openpix.app_id'); // Ensure the app_id is set
            $baseUri = config('services.openpix.base_uri');

            return Client::create($appId, $baseUri);
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
