<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstrumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::Teacher;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Instrument $instrument): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::Teacher;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instrument $instrument): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instrument $instrument): bool
    {
        return $user->role === UserRole::Admin && $instrument->is_available === true;
    }
}
