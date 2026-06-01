<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Band;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class BandStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Band $band)
    {
        $user = auth()->user();
        if($user->role === UserRole::Admin || ($user->role === UserRole::Teacher && $user->teacher->id === $band->teacher_id)) {
            $band->load('students.user');
            $students = $band->students;
            return view('bands.students.index', compact('band', 'students'));
        }
        else {
            return redirect()->back()
                ->with('error', 'Členov kapely môže vidieť len admin alebo učiteľ za ňu zodpovedný');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Band $band)
    {
        $user = auth()->user();
        if($user->role === UserRole::Admin ||
            ($user->role === UserRole::Teacher && $user->teacher->id === $band->teacher_id)) {
            $students = Student::with('user')->latest()->get();
            return view('bands.students.create', compact('band', 'students'));
        }
        else {
            return redirect()->back()
                ->with('error', 'Žiaka môže pridať do kapely iba admin alebo učiteľ zodpovedný za ňu');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Band $band)
    {
        Gate::authorize('update', $band);
        $data = $request->validate([
            'student_id' => ['required', Rule::exists('students', 'id')->whereNull('deleted_at')]
        ]);

        if($band->students()->where('student_id', $data['student_id'])->exists()) {
            return redirect()->back()->with('error', 'Študent už v kapele je');
        }

        if($band->students()->count() >= $band->capacity) {
            return redirect()->back()->with('error', 'Kapapacita kapely je plná');
        }

        $band->students()->attach($data['student_id']);

        return redirect()->route('bands.students.index', $band
        )->with('success', 'Žiak úspešne pridaný do kapely');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band, Student $student)
    {
        Gate::authorize('update', $band);
        $band->students()->detach($student);
        return redirect()->back()
            ->with('success', 'Žiak úspešne vymazaný z kapely');
    }
}
