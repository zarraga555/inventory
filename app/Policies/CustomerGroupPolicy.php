<?php

namespace App\Policies;

use App\Models\CustomerGroup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerGroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('customer-group.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerGroup $customerGroup): bool
    {
        return $user->hasPermissionTo('customer-group.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('customer-group.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerGroup $customerGroup): bool
    {
        return $user->hasPermissionTo('customer-group.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerGroup $customerGroup): bool
    {
        return $user->hasPermissionTo('customer-group.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerGroup $customerGroup): bool
    {
        return $user->hasPermissionTo('customer-group.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerGroup $customerGroup): bool
    {
        return $user->hasPermissionTo('customer-group.force.delete');
    }
}
