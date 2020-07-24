<?php

namespace JamesGordo\LaravelPaypalCheckout\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'JamesGordo\LaravelPaypalCheckout\Http\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load config files
        $this->mergeConfigFrom(__DIR__ . '/../../config/paypal.php', 'paypal');

        // load custom urls
        Route::namespace($this->namespace)
             ->group(__DIR__ . '/../../routes/web.php');

        // export payment config file.
        $this->publishes(
            [__DIR__ . '/../../config/paypal.php' => config_path('paypal.php')],
            'paypal-checkout'
        );

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'paypal');

        $this->publishes(
            [__DIR__ . '/../../resources/views' => base_path('resources/views')],
            'paypal-checkout'
        );
    }
}
