<?php

namespace App\Policies;

use App\Models\Pool;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PoolPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->isAdmin()) {
            //return true;
        }

         return $user->pools->contains('pool_id', $pool->id);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pool $pool): bool
    {
        return $user->pools->contains('pool_id', $pool->id);
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
    public function update(User $user, Pool $pool): bool
    {
        if($user->isAdmin()) {
           // return true;
        }


        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pool $pool): bool
    {
        if($user->isAdmin()) {
            return true;
        }

        return $user->id === $pool->creator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pool $pool): bool
    {
        if($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pool $pool): bool
    {
        if($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
