<?php

namespace App\Policies;

use App\Models\Township;
use App\Models\User;

class TownshipPol
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

    public function edit(User $user, Township $township)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($township);
    }

    public function delete(User $user, Township $township)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($township);
    }
}
