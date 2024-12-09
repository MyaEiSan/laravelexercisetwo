<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPol
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

    public function edit(User $user, Contact $contact)
    {
        // return $user->hasPermission('edit_resource') || $announcement->user_id == $user->id;

        return $user->hasPermission('edit_resource') || $user->isOwner($contact);
    }

    // public function update(User $user, Announcement $announcement)
    // {
    //     return $user->hasPermission('update_resource') || $user->isOwner($announcement);
    // }

    public function delete(User $user, Contact $contact)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($contact);
    }
}
