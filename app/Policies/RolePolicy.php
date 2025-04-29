<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('view role');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('update role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('delete role');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('restore role');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('force delete role');
    }
}
