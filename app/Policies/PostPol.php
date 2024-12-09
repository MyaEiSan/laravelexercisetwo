<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPol
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

    public function edit(User $user, Post $post)
    {
        return $user->hasPermission('edit_resource') || $post->user_id == $user->id;
    }

    public function update(User $user, Post $post)
    {
        return $user->hasPermission('update_resource') || $user->isOwner($post);
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($post);
    }
}
