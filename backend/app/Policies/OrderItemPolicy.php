<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\OrderItem;
use App\Models\User;

class OrderItemPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-order-items');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return mixed
     */
    public function view(User $user, OrderItem $orderItem)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-order-items');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-order-items');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return mixed
     */
    public function update(User $user, OrderItem $orderItem)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-order-items');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return mixed
     */
    public function delete(User $user, OrderItem $orderItem)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-order-items');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return mixed
     */
    public function restore(User $user, OrderItem $orderItem)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-order-items');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return mixed
     */
    public function forceDelete(User $user, OrderItem $orderItem)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-order-items');
    }
}
