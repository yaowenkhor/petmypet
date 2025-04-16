<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Organization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Organization $organization){
        return $user->id === $organization->user_id;
    }

    public function update(User $user, Organization $organization){
        return $user->id === $organization->user_id;
    }

}
