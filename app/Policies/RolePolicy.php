<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('roles.view');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('roles.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('roles.create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('roles.update');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('users.delete');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('roles.restore');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('roles.force.delete');
    }
}
