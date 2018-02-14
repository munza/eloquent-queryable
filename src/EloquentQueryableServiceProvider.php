<?php

namespace Munza\EloquentQueryable;

use Illuminate\Support\ServiceProvider;

class EloquentQueryableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/eloquent-queryable.php'
                => base_path('config/eloquent-queryable.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        if (config('eloquent-queryable')) {
            $this->mergeConfigFrom(
                __DIR__.'/../config/eloquent-queryable.php',
                'eloquent-queryable'
            );
        }
    }
}
