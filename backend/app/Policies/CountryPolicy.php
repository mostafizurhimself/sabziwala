<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Country;
use App\Models\User;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-countries');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function view(User $user, Country $country)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-countries');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-countries');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-countries');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function delete(User $user, Country $country)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-countries');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function restore(User $user, Country $country)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-countries');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Country  $country
     * @return mixed
     */
    public function forceDelete(User $user, Country $country)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-countries');
    }
}
