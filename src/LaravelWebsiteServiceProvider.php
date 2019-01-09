<?php

namespace GorillaDash\LaravelWebsite;

use GorillaDash\LaravelWebsite\Cache\Profiles\CacheAllSuccessfulGetRequests;
use GorillaDash\LaravelWebsite\Commands\CacheWebsiteInfoCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelWebsiteServiceProvider
 *
 * @package GorillaDash\LaravelWebsite
 */
class LaravelWebsiteServiceProvider extends ServiceProvider
{
    /**
     * Config path
     *
     * @var string
     */
    private $configPath = __DIR__ . '/../config/gorilladash.php';

    /**
     * Bootstrap services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        $this->publishes([
            $this->configPath => $this->app->configPath() . '/gorilladash.php',
        ], 'config');

        $this->registerRoutes($router);
        $this->registerCommands();
        $this->registerResources();
        config(['responsecache.cache_profile' => CacheAllSuccessfulGetRequests::class]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->configPath, 'gorilladash');
        $this->app->singleton('laravelwebsite', function () {
            $gorilladash = new GorillaDash(
                config('gorilladash.credentials.website_id'),
                config('gorilladash.credentials.api_access_token')
            );

            return $gorilladash;
        });
    }


    /**
     * Register routes
     *
     * @param \Illuminate\Routing\Router $router
     */
    private function registerRoutes(Router $router): void
    {
        if (!$this->app->routesAreCached()) {
            $options = array_merge([
                'namespace' => 'GorillaDash\LaravelWebsite\Http\Controllers',
                'prefix' => 'gorilladash',
            ], config('gorilladash.routes', []));
            $router->group($options, function () {
                require __DIR__ . '/../routes/api.php';
            });
        }
    }

    /**
     * Register commands
     */
    private function registerCommands()
    {
        $this->commands([
            CacheWebsiteInfoCommand::class,
        ]);
    }

    /**
     *
     */
    private function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'gorilladash');
    }
}
