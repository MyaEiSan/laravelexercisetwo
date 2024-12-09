<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPol
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

    public function edit(User $user, Category $category)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($category);
    }

    public function delete(User $user, Category $category)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($category);
    }
}
