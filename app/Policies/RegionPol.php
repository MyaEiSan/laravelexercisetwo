<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;

class RegionPol
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

    public function edit(User $user, Region $region)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($region);
    }

    public function delete(User $user, Region $region)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($region);
    }
}
