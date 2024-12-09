<?php

namespace App\Policies;

use App\Models\Day;
use App\Models\User;

class DayPol
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

    public function edit(User $user, Day $day)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($day);
    }

    public function delete(User $user, Day $day)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($day);
    }
}
