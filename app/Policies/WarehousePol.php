<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;

class WarehousePol
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

    public function edit(User $user, Warehouse $warehouse)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($warehouse);
    }

    public function delete(User $user, Warehouse $warehouse)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($warehouse);
    }
}
