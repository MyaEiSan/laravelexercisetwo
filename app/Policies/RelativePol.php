<?php

namespace App\Policies;

use App\Models\Relative;
use App\Models\User;

class RelativePol
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

    public function edit(User $user, Relative $relative)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($relative);
    }

    public function delete(User $user, Relative $relative)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($relative);
    }
}
