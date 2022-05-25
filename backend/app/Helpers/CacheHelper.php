<?php

namespace App\Helpers;

use App\Enums\SettingsType;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Get the currency settings
     */
    public function currency()
    {
        return Cache::remember('currency', 3600 * 24, function () {
            return Settings::where('name', SettingsType::CURRENCY())->first() ?? null;
        });
    }
}
