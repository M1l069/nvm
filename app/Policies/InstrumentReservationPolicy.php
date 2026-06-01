<?php

namespace App\Policies;

use App\Enums\InstrumentReservationStatus;
use App\Enums\UserRole;
use App\Models\InstrumentReservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstrumentReservationPolicy
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
    public function view(User $user, InstrumentReservation $instrumentReservation): bool
    {
        if($user->role === UserRole::Admin || $user->role === UserRole::Teacher) {
            return true;
        }

        if($user->role === UserRole::Student) {
            if($user->id === $instrumentReservation->reservedFor->id) {
                return true;
            }
        }

        if ($user->role === UserRole::Parent) {
            $guardian = $user->guardian;

            return $guardian->students()
                ->where('students.user_id', $instrumentReservation->reserved_for)
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::Teacher;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InstrumentReservation $instrumentReservation): bool
    {
        if($user->role === UserRole::Admin ||
            ($user->role === UserRole::Teacher && $instrumentReservation->reservedBy->id === $user->id)) {
            if($instrumentReservation->status !== InstrumentReservationStatus::Completed) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InstrumentReservation $instrumentReservation): bool
    {
        return $user->role === UserRole::Admin ||
        ($user->role === UserRole::Teacher && $instrumentReservation->reservedBy->id === $user->id);
    }
}
