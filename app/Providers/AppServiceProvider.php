<?php

namespace App\Providers;

use App\Clients\FakeStoreProductApiClient;
use App\Contracts\ProductApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ProductApiClient::class,
            fn ($api) => new FakeStoreProductApiClient(
                uri: config('services.fake_store.api_url'),
            ),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
