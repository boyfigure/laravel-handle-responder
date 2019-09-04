<?php

namespace Offspring\Responder;

use Illuminate\Support\ServiceProvider;
use Offspring\Responder\Contracts\Responder as ResponderContract;

class ResponderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerConfigs();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServiceBindings();
        $this->mergeConfigFrom(
            __DIR__ . '/../config/responder.php',
            'responder'
        );
    }

    /**
     * Register config
     */
    protected function registerConfigs()
    {
        $this->publishes([
            __DIR__ . '/../config/responder.php' => config_path('responder.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/lang/en/errors.php' => base_path('resources/lang/en/errors.php'),
        ], 'lang');
    }

    /**
     * Register service bindings.
     *
     * @return void
     */
    protected function registerServiceBindings()
    {
        $this->app->singleton(ResponderContract::class, function ($app) {
            return $app->make(Responder::class);
        });
    }
}
