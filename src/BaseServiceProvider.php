<?php
namespace Backpack\Base;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'backpack');
        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'backpack');
        $this->setupRoutes($this->app->router);

        // use this if your package needs a config file
        $this->publishes([
                __DIR__.'/config/config.php' => config_path('backpack/base.php'),
        ]);
        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/backpack'),
        ]);

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php', 'base'
        );
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Backpack\Base\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // $this->registerBase();

        // use this if your package has a config file
        // config([
        //         'config/skeleton.php',
        // ]);
    }

    // private function registerBase()
    // {
    //     $this->app->bind('base',function($app){
    //         return new Base($app);
    //     });
    // }
}