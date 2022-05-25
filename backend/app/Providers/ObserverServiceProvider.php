<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Payslip;
use App\Models\RefundRequest;
use App\Models\Rider;
use App\Models\Settings;
use App\Models\Zone;
use App\Observers\CustomerObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\PayslipObserver;
use App\Observers\RefundRequestObserver;
use App\Observers\RiderObserver;
use App\Observers\SettingsObserver;
use App\Observers\ZoneObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Customer::observe(CustomerObserver::class);
        Rider::observe(RiderObserver::class);
        Order::observe(OrderObserver::class);
        RefundRequest::observe(RefundRequestObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Settings::observe(SettingsObserver::class);
    }
}