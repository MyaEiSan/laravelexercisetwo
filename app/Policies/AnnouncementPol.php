<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPol
{

    // use HandlesAuthorization;
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

    public function edit(User $user, Announcement $announcement)
    {
        // return $user->hasPermission('edit_resource') || $announcement->user_id == $user->id;

        return $user->hasPermission('edit_resource') || $user->isOwner($announcement);
    }

    // public function update(User $user, Announcement $announcement)
    // {
    //     return $user->hasPermission('update_resource') || $user->isOwner($announcement);
    // }

    public function delete(User $user, Announcement $announcement)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($announcement);
    }
    
}
