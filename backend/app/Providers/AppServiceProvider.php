<?php

namespace App\Providers;

use App\Enums\PaymentMethod;
use App\Facades\Helper;
use App\Library\OrderHandler;
use App\Library\WalletHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        // Register the order handler
        $this->app->bind(OrderHandler::class, function ($app) {
            return new OrderHandler(request()->get('paymentMethod'));
        });

        // Register the wallet handler
        $this->app->bind(WalletHandler::class, function ($app) {
            return new WalletHandler(request()->get('paymentMethod'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('production')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}