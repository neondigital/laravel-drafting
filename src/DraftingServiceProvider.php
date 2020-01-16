<?php

namespace NeonDigital\Drafting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

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

        Blueprint::macro('drafting', function () {
            $this->timestamp('drafted_at')->nullable()->index();
            $this->integer('draft_parent_id')->nullable()->unsigned();
            $this->foreign('draft_parent_id')->references('id')->on($this->getTable());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('drafting', function ($app) {
            return new DraftManager($app);
            // return $app->make(DraftManager::class);
        });
    }
}
