<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPol
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

    public function edit(User $user, Student $student)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($student);
    }

    public function delete(User $user, Student $student)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($student);
    }
}
