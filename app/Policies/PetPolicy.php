<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Organization;
use App\Models\Pet;
use Illuminate\Auth\Access\HandlesAuthorization;

class PetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function before(User $user): ?bool
    {
        if($user->role != 'organization') {
            return false;
        }
        return null;
    }

    public function view(User $user, Pet $pet): bool{
        $organization = $user->organization;
        return $organization->id === $pet->organization_id;
    }

    public function create(User $user): bool
    {
        //$organization = Organization::where("user_id", $user->id)->first();
        $organization = $user->organization;

        if (!$organization) {
            return false;
        }

        if ($organization->status != 'approved') {
            return false;
        }

        return true;

    }

    public function delete(User $user , Pet $pet): bool
    {
        $organization = $user->organization;
        return $organization->id === $pet->organization_id;

    }

    public function update(User $user , Pet $pet): bool
    {
        $organization = $user->organization;
        return $organization->id === $pet->organization_id;

    }

}