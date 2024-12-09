<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPol
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

    public function edit(User $user, Lead $lead)
    {

        return $user->hasPermission('edit_resource') || $user->isOwner($lead);
    }

    public function delete(User $user, Lead $lead)
    {
        return $user->hasPermission('delete_resource') || $user->isOwner($lead);
    }
}
