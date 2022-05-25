<?php

namespace App\Models;


use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Settings extends Model implements HasMedia
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];


    use InteractsWithMedia;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['primaryMediaUrl'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'update'];

    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('primary')
            ->singleFile();
    }

    /**
     * Get the primary media
     */
    public function getPrimaryMediaUrlAttribute()
    {
        return $this->getFirstMediaUrl('primary') ?? null;
    }
}