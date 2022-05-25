<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Unit;
use App\Models\User;

class UnitPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-units');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function view(User $user, Unit $unit)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-units');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-units');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function update(User $user, Unit $unit)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-units');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function delete(User $user, Unit $unit)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-units');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function restore(User $user, Unit $unit)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-units');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Unit  $unit
     * @return mixed
     */
    public function forceDelete(User $user, Unit $unit)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-units');
    }
}
