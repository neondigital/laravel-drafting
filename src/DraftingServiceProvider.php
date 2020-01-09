<?php

namespace NeonDigital\Drafting;

use Illuminate\Support\ServiceProvider;

class DraftingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton('drafting', function () {
        //     return new VersionService;
        // });
    }
}
