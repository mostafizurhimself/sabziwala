<?php

namespace App\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Jedrzej\Sortable\SortableTrait;
use Spatie\Permission\Models\Role as Base;

class Role extends Base
{
    use SortableTrait, Filterable;

    /**
     * Name of super admin role
     * 
     * @var string
     */
    public const SUPER_ADMIN = 'Super Admin';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Available sortable fields
     *
     * @var array
     */
    public $sortable = ['*'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'create', 'update', 'delete'];

    /**
     * Set the default sort citeria
     *
     * @var array
     */
    protected $defaultSortCriteria = ['created_at,desc'];

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
     * Scope a query to only exclude admin role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutSuperAdmin($query)
    {
        return $query->where('name', '!=', Role::SUPER_ADMIN);
    }

    /**
     * Get Permissions attribute
     * 
     * @return array
     */
    public function getPermissionsAttribute()
    {
        return $this->permissions()->get()->map(function ($permission) {
            return $permission->id;
        });
    }
}