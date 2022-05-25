<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\settings;
use App\Models\User;

class SettingsPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-settings');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\settings  $settings
     * @return mixed
     */
    public function view(User $user, settings $settings)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-settings');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-settings');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\settings  $settings
     * @return mixed
     */
    public function update(User $user, settings $settings)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-settings');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\settings  $settings
     * @return mixed
     */
    public function delete(User $user, settings $settings)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-settings');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\settings  $settings
     * @return mixed
     */
    public function restore(User $user, settings $settings)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-settings');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\settings  $settings
     * @return mixed
     */
    public function forceDelete(User $user, settings $settings)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-settings');
    }
}
