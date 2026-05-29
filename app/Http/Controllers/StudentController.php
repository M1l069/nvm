<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StudentRequest;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('specialization.department',
            'bands', 'guardians')->latest()->paginate();

        return view('admin-teacher.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::latest()->get();
        return view('admin.students.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
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

//         if(Carbon::parse($student->birth_date)->greaterThan(now()->subYears(18))) {
//             return redirect()->route('guardians.edit', $student)
//                 ->with('success', 'Študent úspešne vytvorený. Prosím vytvorte konto
//                 jeho zákonným zástupcom');
//         }

         return redirect()->route('students.show', $student)
             ->with('success', 'Žiak úspešne vytvorený');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateUsername(string $firstName, string $lastName):string {
        $firstName = Str::ascii(Str::lower($firstName));
        $lastName = Str::ascii(Str::lower($lastName));

        $firstName = preg_replace('/[^a-z]/', '', $firstName);
        $lastName = preg_replace('/[^a-z]/', '', $lastName);

        $baseUsername = 'x' . $lastName;

        if (!User::where('username', $baseUsername)->exists()) {
            return $baseUsername;
        }

        for ($i = 1; $i <= strlen($firstName); $i++) {
            $username = $baseUsername . substr($firstName, 0, $i);

            if (!User::where('username', $username)->exists()) {
                return $username;
            }
        }

        $counter = 1;

        do {
            $username = $baseUsername . $firstName . $counter;
            $counter++;
        } while (User::where('username', $username)->exists());

        return $username;
    }
}
