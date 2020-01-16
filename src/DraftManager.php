<?php

namespace NeonDigital\Drafting;

use Illuminate\Support\Manager;
use NeonDigital\Drafting\Drafters\EloquentDrafter;

class DraftManager extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Build a drafter instance
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \Laravel\Socialite\Two\AbstractProvider
     */
    public function buildDrafter($className)
    {
        return $this->app->make($className);
    }

    /**
     * Create an eloquent model drafter
     *
     * @return EloquentDrafter
     */
    public function createEloquentDriver()
    {
        return $this->buildDrafter(EloquentDrafter::class);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'eloquent';
    }
}