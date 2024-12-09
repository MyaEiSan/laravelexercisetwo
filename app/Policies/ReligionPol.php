<?php

namespace App\Policies;

use App\Models\Religion;
use App\Models\User;

class ReligionPol
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

    public function edit(User $user, Religion $religion)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($religion);
    }

    public function delete(User $user, Religion $religion)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($religion);
    }
}
