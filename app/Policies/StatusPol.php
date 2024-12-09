<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;

class StatusPol
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

    public function edit(User $user, Status $status)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($status);
    }

    public function delete(User $user, Status $status)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($status);
    }
}
