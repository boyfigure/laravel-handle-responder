<?php

namespace Offspring\Responder;

use Illuminate\Support\ServiceProvider;
use Offspring\Responder\Contracts\Responder as ResponderContract;
use Offspring\Responder\Contracts\ResponseFactory as ResponseFactoryContract;
use Offspring\Responder\Contracts\ResponseFactory;
use Offspring\Responder\Http\Responses\Factories\LaravelResponseFactory;

use Offspring\Responder\Contracts\ErrorMessageResolver as ErrorMessageResolverContract;
use Offspring\Responder\Contracts\ErrorFactory as ErrorFactoryContract;
use Offspring\Responder\Http\Responses\ErrorResponseBuilder;
use Offspring\Responder\Contracts\ErrorSerializer as ErrorSerializerContract;

use Offspring\Responder\Contracts\SuccessSerializer as SuccessSerializerContract;
use Offspring\Responder\Contracts\SuccessFactory as SuccessFactoryContract;
use Offspring\Responder\Http\Responses\SuccessResponseBuilder;

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
        $this->registerSuccessBindings();
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
            return $this->decorateResponseFactory($app->make(LaravelResponseFactory::class));
        });
    }


    protected function decorateResponseFactory(ResponseFactoryContract $factory): ResponseFactory
    {
        foreach ($this->app->config['responder.decorators'] as $decorator) {
            $factory = new $decorator($factory);
        };

        return $factory;
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

        $this->app->bind(ErrorSerializerContract::class, function ($app) {
            return $app->make($app->config['responder.serializers.error']);
        });

        $this->app->bind(ErrorResponseBuilder::class, function ($app) {
            return (new ErrorResponseBuilder($app->make(ResponseFactoryContract::class), $app->make(ErrorFactoryContract::class)))->serializer($app->make(ErrorSerializerContract::class));
        });
    }

    protected function registerSuccessBindings()
    {

        $this->app->singleton(SuccessFactoryContract::class, function ($app) {
            return $app->make(SuccessFactory::class);
        });

        $this->app->bind(SuccessSerializerContract::class, function ($app) {
            return $app->make($app->config['responder.serializers.success']);
        });

        $this->app->bind(SuccessResponseBuilder::class, function ($app) {
            return (new SuccessResponseBuilder($app->make(ResponseFactoryContract::class), $app->make(SuccessFactoryContract::class)))->serializer($app->make(SuccessSerializerContract::class));
        });
    }
}
