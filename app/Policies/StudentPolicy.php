<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->role === UserRole::Admin || $user->role === UserRole::Teacher) {
            return true;
        }
        return false;
            ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        if($student->trashed()) {
            return $user->role === UserRole::Admin;
        }

        if($user->role === UserRole::Admin) {
            return true;
        }

        if ($user->role === UserRole::Student) {
            return $student->user_id === $user->id;
        }

        if($user->role === UserRole::Parent) {
            return $student->guardians()->where('guardian.user_id', $user->id)->exists();
        }

        if($user->role === UserRole::Teacher) {
            return $student->enrollments()
                ->whereHas('subjectSchoolYear', function ($query) use ($user) {
                    $query->where('teacher_id', $user->teacher->id);
                })
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->role === UserRole::Admin) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {

        if($user->role === UserRole::Admin) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        if($user->role === UserRole::Admin) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Student $student): bool
    {
        if($user->role === UserRole::Admin) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        return $user->role === UserRole::Admin;
    }
}
