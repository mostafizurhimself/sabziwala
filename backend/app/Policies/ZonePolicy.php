<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Zone;
use App\Models\User;

class ZonePolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-zones');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Zone  $zone
     * @return mixed
     */
    public function view(User $user, Zone $zone)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-zones');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-zones');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Zone  $zone
     * @return mixed
     */
    public function update(User $user, Zone $zone)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-zones');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Zone  $zone
     * @return mixed
     */
    public function delete(User $user, Zone $zone)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-zones');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Zone  $zone
     * @return mixed
     */
    public function restore(User $user, Zone $zone)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-zones');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Zone  $zone
     * @return mixed
     */
    public function forceDelete(User $user, Zone $zone)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-zones');
    }
}
