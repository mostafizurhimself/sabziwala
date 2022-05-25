<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Rider;
use App\Models\User;

class RiderPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-riders');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rider  $rider
     * @return mixed
     */
    public function view(User $user, Rider $rider)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-riders');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-riders');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rider  $rider
     * @return mixed
     */
    public function update(User $user, Rider $rider)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-riders');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rider  $rider
     * @return mixed
     */
    public function delete(User $user, Rider $rider)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-riders');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rider  $rider
     * @return mixed
     */
    public function restore(User $user, Rider $rider)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-riders');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rider  $rider
     * @return mixed
     */
    public function forceDelete(User $user, Rider $rider)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-riders');
    }
}
