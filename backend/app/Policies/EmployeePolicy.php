<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-employees');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-employees');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-employees');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-employees');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-employees');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-employees');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-employees');
    }
}
