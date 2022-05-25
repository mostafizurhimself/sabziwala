<?php

namespace App\Observers;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingsObserver
{
    /**
     * Handle the Settings "created" event.
     *
     * @param  \App\Models\Settings  $settings
     * @return void
     */
    public function created(Settings $settings)
    {
        //
    }

    /**
     * Handle the Settings "updated" event.
     *
     * @param  \App\Models\Settings  $settings
     * @return void
     */
    public function updated(Settings $settings)
    {
        Cache::forget('currency');
    }

    /**
     * Handle the Settings "deleted" event.
     *
     * @param  \App\Models\Settings  $settings
     * @return void
     */
    public function deleted(Settings $settings)
    {
        //
    }

    /**
     * Handle the Settings "restored" event.
     *
     * @param  \App\Models\Settings  $settings
     * @return void
     */
    public function restored(Settings $settings)
    {
        //
    }

    /**
     * Handle the Settings "force deleted" event.
     *
     * @param  \App\Models\Settings  $settings
     * @return void
     */
    public function forceDeleted(Settings $settings)
    {
        //
    }
}
