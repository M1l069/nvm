<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Traits\GeneratesUsernames;
use App\Http\Requests\GuardianRequest;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuardianController extends Controller
{
    use GeneratesUsernames;
    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student)
    {
        Gate::authorize('create', Guardian::class);
        if($student->guardians()->count() >= 2) {
            return redirect()->route('students.show', $student)
                ->with('error', 'Žiak už má 2 zákonných zástupcov');
        }
        return view('guardian.admin.create', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardianRequest $request, Student $student)
    {
        Gate::authorize('create', Guardian::class);

        if($student->guardians()->count() >= 2) {
            return redirect()->route('students.show', $student)
                ->with('error', 'Žiak už má 2 zákonných zástupcov');
        }

        $data = $request->validated();
        $password = Str::password(12);
        $userName = $this->generateUsername($data['first-name'], $data['surename']);

        $user = User::create([
            'name' => $data['first-name'] . " " . $data['surename'],
            'username' => $userName,
            'password' => Hash::make($password),
            'role' => UserRole::Parent->value,
            'must_change_password' => true
        ]);

        $guardian = Guardian::create([
            'user_id' => $user->id,
            'phone_number' => phone($data['phone_number'], 'SK')->formatE164(),
        ]);

        $student->guardians()->attach($guardian->id);

        return redirect()->route('students.guardians.show', ['student' => $student, 'guardian' => $guardian])
            ->with('success', 'Zákonný zástupca bol úspešne vytvorený.')
            ->with('temporaryPassword', $password);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student, Guardian $guardian)
    {
        $guardian->load('user');
        $student->load('user');
        return view('guardian.show', compact('student', 'guardian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student, Guardian $guardian)
    {
        $student->load('user');
        $guardian->load('user');
        return view('guardian.admin.edit', compact('student', 'guardian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuardianRequest $request, Student $student, Guardian $guardian)
    {
        Gate::authorize('update', $guardian);
        $data = $request->validated();

        $guardian->user->update([
            'name' => $data['first-name'] . " " . $data['surename'],
            'email' => $data['email']
        ]);

        $guardian->update([
            'phone_number' => phone($data['phone_number'], 'SK')->formatE164(),
        ]);

        return redirect()->route('students.guardians.show', ['student' => $student, 'guardian' => $guardian])
            ->with('success', 'Zákonný zástupca bol úspešne upravený.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
