<?php

namespace Offspring\Responder;

use Illuminate\Support\ServiceProvider;

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

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/responder.php',
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
}
