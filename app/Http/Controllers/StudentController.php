<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StudentRequest;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Traits\GeneratesUsernames;

class StudentController extends Controller
{
    use GeneratesUsernames;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Student::class);
        $students = Student::withTrashed()->with('specialization.department',
            'bands', 'guardians')->latest()->paginate();

        return view('admin-teacher.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Student::class);
        $specializations = Specialization::latest()->get();
        return view('admin.students.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        Gate::authorize('create', Student::class);
        $data = $request->validated();
        $temporaryPassword = Str::password(12);
        $userName = $this->generateUsername($data['first-name'], $data['surename']);

         $user = User::create([
            'name' => $data['first-name'] . " " . $data['surename'],
             'username' => $userName,
             'email' => $data['email'],
             'password' => Hash::make($temporaryPassword),
             'role' => UserRole::Student->value,
             'must_change_password' => true
         ]);

         $student = Student::create([
             'user_id' => $user->id,
             'specialization_id' => $data['specialization'],
             'birth_date' => $data['birth_date'],
             'phone_number' => empty($data['phone_number']) ? null : phone($data['phone_number'], 'SK')->formatE164(),
             'street' => $data['street'],
             'city' => $data['city'],
             'postal_code' => $data['postal_code'],
             'country' => $data['country']
         ]);

         if(Carbon::parse($student->birth_date)->age < 18) {
             return redirect()->route('students.guardians.create', $student)
                 ->with('success', 'Študent úspešne vytvorený. Prosím vytvorte konto
                 jeho zákonným zástupcom');
         }

         return redirect()->route('students.show', $student)
             ->with('success', 'Žiak úspešne vytvorený')
             ->with('temporaryPassword', $temporaryPassword);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);
        $student = $student->load('specialization.department', 'guardians.user', 'user.instrumentReservationsFor.instrument');

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        Gate::authorize('update', $student);
        $student = $student->load('user' ,'specialization.department');
        $specializations = Specialization::latest()->get();
        return view('admin.students.edit', ['student' => $student, 'specializations' => $specializations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
        Gate::authorize('update', $student);
        $data = $request->validated();

        $student->user->update([
            'name' => $data['first-name'] . " " . $data['surename'],
            'email' => $data['email'],
        ]);

        $student->update([
            'specialization_id' => $data['specialization'],
            'birth_date' => $data['birth_date'],
            'phone_number' => empty($data['phone_number']) ? null : phone($data['phone_number'], 'SK')->formatE164(),
            'street' => $data['street'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country']
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Žiak úspešne upravený !');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Gate::authorize('delete', $student);
        $user = $student->user;

        $student->delete();
        $user?->delete();

        return redirect()->route('students.index')
            ->with('success', 'Študent úspešne vymazaný');
    }

    public function restore($student)
    {
        $student = Student::withTrashed()->findOrFail($student);
        Gate::authorize('restore', $student);

        $student->restore();

        if ($student->user()->withTrashed()->exists()) {
            $student->user()->withTrashed()->first()->restore();
        }

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Žiak bol úspešne obnovený.');
    }

    public function forceDelete($student)
    {
        $student = Student::withTrashed()
            ->with(['user' => fn ($query) => $query->withTrashed()])
            ->findOrFail($student);
        Gate::authorize('forceDelete', $student);


        if (! $student->trashed()) {
            return redirect()
                ->route('students.show', $student)
                ->with('error', 'Žiaka je potrebné najskôr vymazať.');
        }

        $user = $student->user;

        $student->forceDelete();

        $user?->forceDelete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Žiak bol trvalo vymazaný.');
    }

//    private function generateUsername(string $firstName, string $lastName):string {
//        $firstName = Str::ascii(Str::lower($firstName));
//        $lastName = Str::ascii(Str::lower($lastName));
//
//        $firstName = preg_replace('/[^a-z]/', '', $firstName);
//        $lastName = preg_replace('/[^a-z]/', '', $lastName);
//
//        $baseUsername = 'x' . $lastName;
//
//        if (!User::where('username', $baseUsername)->exists()) {
//            return $baseUsername;
//        }
//
//        for ($i = 1; $i <= strlen($firstName); $i++) {
//            $username = $baseUsername . substr($firstName, 0, $i);
//
//            if (!User::where('username', $username)->exists()) {
//                return $username;
//            }
//        }
//
//        $counter = 1;
//
//        do {
//            $username = $baseUsername . $firstName . $counter;
//            $counter++;
//        } while (User::where('username', $username)->exists());
//
//        return $username;
//    }
}
