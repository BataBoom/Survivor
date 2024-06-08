<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\SurvivorRegistration;
use App\Models\Survivor;
use App\Models\Pool;
use Illuminate\Auth\Access\Response;

class SurvivorRegistrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, SurvivorRegistration $survivorRegistration): bool
    {
        if($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SurvivorRegistration $survivorRegistration): bool
    {
        return $survivorRegistration->contains('user_id', $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->isAdmin()) {
            //return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user,  SurvivorRegistration $survivorRegistration): bool
    {
        if($user->isAdmin()) {
           // return true;
        }

        return $survivorRegistration->alive;

    }


}
