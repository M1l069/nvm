<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display basic information about user. Specific user roles get to see specific information
     */
    public function show(User $user)
    {
        $user = request()->user();
        if($user->role === \App\Enums\UserRole::Student) {
            $user = request()->user()->load('student.specialization.department',
                'student.guardians' , 'student.guardians.user');
        }

        else if($user->role === \App\Enums\UserRole::Teacher) {
            $user = request()->user()->load('teacher.specialization.department');
        }

        else if($user->role === \App\Enums\UserRole::Parent) {
            $user = request()->user()->load('guardian.students' ,'guardian.students.user',
            'guardian.students.specialization.department');
        }
        return view('user.show', ['user' => $user]);
    }
}
