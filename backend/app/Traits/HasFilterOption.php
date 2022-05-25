<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;


trait HasFilterOption
{
    /**
     * Get the filter options of the model
     * 
     * @return array
     */
    public static function filterOptions()
    {
        return Cache::remember(self::readableName(), 3600 * 24, function () {
            return self::orderBy('id', 'desc')->get();
        });
    }

    /**
     * Forget cache on model events
     */
    public static function bootHasFilterOption()
    {
        static::created(function ($model) {
            Cache::forget(self::readableName());
        });

        static::updated(function ($model) {
            Cache::forget(self::readableName());
        });

        static::deleted(function ($model) {
            Cache::forget(self::readableName());
        });
    }
}