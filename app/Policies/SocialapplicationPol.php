<?php

namespace App\Policies;

use App\Models\Socialapplication;
use App\Models\User;

class SocialapplicationPol
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

    public function edit(User $user, Socialapplication $socialapplication)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($socialapplication);
    }

    public function delete(User $user, Socialapplication $socialapplication)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($socialapplication);
    }
}
