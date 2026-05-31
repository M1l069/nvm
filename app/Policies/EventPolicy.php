<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Band;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        if(!$event->trashed()) {
            return true;
        }
        else {
            return $user->role === UserRole::Admin;
        }
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->role === UserRole::Admin) {
            return true;
        }

        if($user->role === UserRole::Teacher) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        if($user->role === UserRole::Admin) {
            return true;
        }

        $event->loadMissing(['participants', 'bands']);

        if($user->role === UserRole::Teacher) {
            $teacher = $user->teacher;
            if(! $teacher) {
                return false;
            }
            return $event->teacher_id === $teacher->id
                || $event->bands->contains('teacher_id', $teacher->id);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        if ($user->role === UserRole::Teacher) {
            if (! $user->teacher) {
                return false;
            }

            return $event->teacher_id === $user->teacher->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return false;
    }
}
