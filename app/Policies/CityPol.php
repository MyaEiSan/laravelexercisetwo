<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;

class CityPol
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

    public function edit(User $user, City $city)
    {
        return $user->hasPermission('edit_resource') || $user->isOwner($city);
    }

    public function delete(User $user, City $city)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($city);
    }
}
