<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\TeacherRequest;
use App\Models\Specialization;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Traits\GeneratesUsernames;

class TeacherController extends Controller
{
    use GeneratesUsernames;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::withTrashed()
            ->with([
                'user' => fn ($query) => $query->withTrashed(),
                'specialization.department',
                'bands',
            ])->latest()
            ->paginate();
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::latest()->get();
        return view('teachers.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        $data = $request->validated();
        $temporaryPassword = Str::password(12);
        $userName = $this->generateUsername($data['first-name'], $data['surename']);


        $user = User::create([
            'name' => $data['first-name'] . " " . $data['surename'],
            'username' => $userName,
            'email' => $data['email'],
            'password' => Hash::make($temporaryPassword),
            'role' => UserRole::Teacher->value,
            'must_change_password' => true
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'specialization_id' => $data['specialization'],
        ]);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Učiteľ úspešne vytvorený.')
            ->with('temporaryPassword', $temporaryPassword);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('user', 'specialization.department', 'bands.students', 'user.instrumentReservations',
        'user.roomReservations.room', 'user.roomReservations.reservedBy');
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $specializations = Specialization::latest()->get();
        return view('teachers.edit', compact('teacher', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $data = $request->validated();
        $teacher->user->update([
            'name' => $data['first-name'] . " " . $data['surename'],
            'email' => $data['email'],
        ]);

        $teacher->update([
            'specialization_id' => $data['specialization'],
        ]);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Učiteľ úspešne upravený.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $user = $teacher->user;
        $teacher->delete();
        $user?->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'Učiteľ úspešne vymazaný.');
    }

    public function restore($teacher) {
        $teacher = Teacher::withTrashed()->findOrFail($teacher);
        // gate
        $teacher->restore();

        if($teacher->user()->withTrashed()->exists()) {
            $teacher->user()->withTrashed()->first()->restore();
        }

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Učiteľ úspešne obnovený');
    }
}
