<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPol
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

    public function edit(User $user, Permission $permission)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($permission);
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($permission);
    }
}
