<?php

namespace App\Models;

use App\Models\Unit;
use App\Facades\Helper;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;

class Product extends Model implements HasMedia, ReviewRateable
{
    use InteractsWithMedia, Favoriteable, ReviewRateableTrait;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['mediaCollection', 'thumbnailMedia', 'thumbnailMediaUrl', 'actualPriceFormatted',  'salePriceFormatted', 'averageRatings'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'opening_quantity', 'alert_quantity', 'quantity'
    ];

    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {

        $this
            ->addMediaCollection('thumbnail')
            ->singleFile();

        $this
            ->addMediaCollection('collection');
    }

    /**
     * Get the Category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * The tags that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Review::class, 'reviewrateable');
    }

    /**
     * Get the thumbnail media
     */
    public function getThumbnailMediaAttribute()
    {
        return $this->getFirstMedia('thumbnail') ?? null;
    }

    /**
     * Get the thumbnail media
     */
    public function getThumbnailMediaUrlAttribute()
    {
        return $this->getFirstMediaUrl('thumbnail') ?? null;
    }



    /**
     * Check is favourite for the current user or not
     */
    public function getIsFavouriteAttribute()
    {
        return $this->isFavorited();
    }


    /**
     * Get the sale price  as formatted
     */
    public function getActualPriceFormattedAttribute()
    {
        $value = new Money(ceil($this->actualPrice), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

    /**
     * Get the sale price  as formatted
     */
    public function getSalePriceFormattedAttribute()
    {
        $value = new Money(ceil($this->salePrice), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }


    /**
     * Get the media collection
     */
    public function getMediaCollectionAttribute()
    {
        $result = [];
        foreach ($this->getMedia('collection') as $media) {
            array_push($result, ['id' => $media->id, 'name' => $media->name, 'fileName' => $media->file_name,  'url' => $media->getFullUrl(), 'mimeType' => $media->mime_type]);
        }

        return $result;
    }


    /**
     * Get the Average Rating
     */
    public function getAverageRatingsAttribute()
    {
        return $this->ratings->where('approved', true)->average('rating');
    }
}
