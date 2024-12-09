<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePol
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user)
    {
        return $user->hasPermission('view_resource');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_resource');
    }

    public function edit(User $user, Role $role)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($role);
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($role);
    }
}
