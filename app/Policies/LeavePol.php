<?php

namespace App\Policies;

use App\Models\Leave;
use App\Models\User;

class LeavePol
{
    /**
     * Create a new policy instance.
     */

    //  Admin can view all leave data 
    public function viewany(User $user){
        // check if the user has the 'Admin' role 
        return $user->hasRoles(['Admin','Teacher']);
    }

    // Users can view their own leave data 
    public function view(User $user,Leave $leave)
    {
        // allow if the user has the required permission or is the owner of the leave
        return $user->hasPermission('view_resource') || $user->isOwner($leave);
    }

    public function create(User $user)
    {
        return $user->hasRoles(['Teacher','Student']);
    }

    public function edit(User $user, Leave $leave)
    {
        // allow Admin, Teacher to edit all leave records 
        if($user->hasRoles(['Admin','Teacher'])){
            return true; 
        }

        return $leave->user_id == $user->id;
    }

    public function delete(User $user, Leave $leave)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($leave);
    }
}
