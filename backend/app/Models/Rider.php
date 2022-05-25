<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Enums\AddressType;
use App\Traits\CamelCasing;
use App\Traits\HasFilterOption;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Spatie\MediaLibrary\HasMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable implements JWTSubject, HasMedia
{
    use  Notifiable, HasFactory, CamelCasing, Sortable, Filterable, InteractsWithMedia, HasFilterOption;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'create', 'update'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media', 'address'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name', 'profilePhotoUrl', 'verificationFrontUrl', 'verificationBackUrl',
        'lastLoginForHuman', 'attachmentUrls', 'presentAddress', 'permanentAddress', 'type'
    ];

    /**
     * Available sortable fields
     *
     * @var array
     */
    public $sortable = ['*'];

    /**
     * Set the default sort citeria
     *
     * @var array
     */
    protected $defaultSortCriteria = ['created_at,desc'];

    /**
     * Scope a query to only active customers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
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
     * Get the human readable name of the resource
     *
     * @return string
     */
    public static function readableName()
    {
        $string = Str::kebab((new \ReflectionClass(get_called_class()))->getShortName());
        return Str::plural($string);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the supplier address
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function address()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get billing address attribute
     *
     * @return mixed
     */
    public function getPresentAddressAttribute()
    {
        if ($this->address) {
            return $this->address->where('type', AddressType::PRESENT_ADDRESS())->first();
        }
    }

    /**
     * Get shipping address attribute
     *
     * @return mixed
     */
    public function getPermanentAddressAttribute()
    {
        if ($this->address) {
            return $this->address->where('type', AddressType::PERMANENT_ADDRESS())->first();
        }
    }

    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile-photo')->singleFile();
        $this->addMediaCollection('verification-front')->singleFile();
        $this->addMediaCollection('verification-back')->singleFile();
        $this->addMediaCollection('attachments');
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Rider\ResetPasswordNotification($token));
    }

    /**
     * Get the user type
     */
    public function getTypeAttribute()
    {
        return 'rider';
    }

    /**
     * Get the profile-photo media
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->getFirstMediaUrl('profile-photo') ?? null;
    }

    /**
     * Get the verification image url front
     */
    public function getVerificationFrontUrlAttribute()
    {
        return $this->getFirstMediaUrl('verification-front') ?? null;
    }

    /**
     * Get the verification image url back
     */
    public function getVerificationBackUrlAttribute()
    {
        return $this->getFirstMediaUrl('verification-back') ?? null;
    }

    /**
     * Get the full name attribute
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->firstName . " " . $this->lastName;
    }

    /**
     * Get the last login date for humans
     *
     * @return string
     */
    public function getLastLoginForHumanAttribute()
    {
        return $this->lastLogin ? $this->lastLogin->diffForHumans() : null;
    }

    /**
     * Get the media collection
     */
    public function getAttachmentUrlsAttribute()
    {
        $result = [];
        foreach ($this->getMedia('attachments') as $media) {
            array_push($result, ['id' => $media->id, 'name' => $media->name, 'fileName' => $media->file_name,  'url' => $media->getFullUrl(), 'mimeType' => $media->mime_type]);
        }

        return $result;
    }
}
