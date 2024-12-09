<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPol
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

    public function edit(User $user, Tag $tag)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($tag);
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($tag);
    }
}
