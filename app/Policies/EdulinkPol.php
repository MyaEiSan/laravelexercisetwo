<?php

namespace App\Policies;

use App\Models\Edulink;
use App\Models\User;

class EdulinkPol
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

    public function edit(User $user, Edulink $edulink)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($edulink);
    }

    public function delete(User $user, Edulink $edulink)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($edulink);
    }
}
