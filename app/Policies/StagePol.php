<?php

namespace App\Policies;

use App\Models\Stage;
use App\Models\User;

class StagePol
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

    public function edit(User $user, Stage $stage)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($stage);
    }

    public function delete(User $user, Stage $stage)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($stage);
    }
}
