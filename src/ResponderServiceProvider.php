<?php

namespace Offspring\Responder;

use Illuminate\Support\ServiceProvider;
use Offspring\Responder\Contracts\Responder as ResponderContract;
use Offspring\Responder\Contracts\ResponseFactory as ResponseFactoryContract;
use Offspring\Responder\Http\Responses\Factories\LaravelResponseFactory;

use Offspring\Responder\Contracts\ErrorMessageResolver as ErrorMessageResolverContract;
use Offspring\Responder\Contracts\ErrorFactory as ErrorFactoryContract;
use Offspring\Responder\Http\Responses\ErrorResponseBuilder;
use Offspring\Responder\Contracts\ErrorSerializer as ErrorSerializerContract;

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
        $this->mergeConfigFrom(
            __DIR__ . '/../config/responder.php',
            'responder'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResponseFactory();
        $this->registerSerializerBindings();
        $this->registerServiceBindings();
        $this->registerErrorBindings();

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

    /**
     * Register Laravel bindings.
     *
     * @return void
     */
    protected function registerResponseFactory()
    {
        $this->app->singleton(ResponseFactoryContract::class, function ($app) {
            return $app->make(LaravelResponseFactory::class);
        });
    }

    /**
     * Register error bindings.
     *
     * @return void
     */
    protected function registerErrorBindings()
    {
        $this->app->singleton(ErrorMessageResolverContract::class, function ($app) {
            return $app->make(ErrorMessageResolver::class);
        });

        $this->app->singleton(ErrorFactoryContract::class, function ($app) {
            return $app->make(ErrorFactory::class);
        });

        $this->app->bind(ErrorResponseBuilder::class, function ($app) {
            return (new ErrorResponseBuilder($app->make(ResponseFactoryContract::class), $app->make(ErrorFactoryContract::class)))->serializer($app->make(ErrorSerializerContract::class));
        });
    }

    /**
     * Register serializer bindings.
     *
     * @return void
     */
    protected function registerSerializerBindings()
    {
        $this->app->bind(ErrorSerializerContract::class, function ($app) {
            return $app->make($app->config['responder.serializers.error']);
        });

//        $this->app->bind(SerializerAbstract::class, function ($app) {
//            return $app->make($app->config['responder.serializers.success']);
//        });
    }
}
