<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;

class CountryPol
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

    public function edit(User $user, Country $country)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($country);
    }

    public function delete(User $user, Country $country)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($country);
    }
}
