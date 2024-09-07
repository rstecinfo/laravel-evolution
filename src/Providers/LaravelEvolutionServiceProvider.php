<?php

namespace Luanrodrigues\LaravelEvolution\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelEvolutionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/evolution.php' => config_path('evolution.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/evolution.php', 'evolution'
        );
    }
}
