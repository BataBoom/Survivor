<?php

namespace App\Policies;

use App\Models\Survivor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Carbon\Carbon;

class SurvivorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Survivor $survivor): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Survivor $survivor): bool
    {

    }

    /**
     * Determine whether the user can delete a survivor pick
     */
    public function delete(User $user, Survivor $survivor): bool
    {
        if(is_null($survivor->result) && Carbon::now()->lessThan(Carbon::parse($survivor->question->starts_at))) {
            return true;
        } else {
           return false;
        }

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Survivor $survivor): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Survivor $survivor): bool
    {
        //
    }
}
