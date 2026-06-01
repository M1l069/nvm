<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\BandRequest;
use App\Models\Band;
use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === UserRole::Admin) {
            $bands = Band::withTrashed()->with('teacher.user')->withCount('students')->latest()->paginate();
        }

        else {
            $bands = Band::with('teacher.user')->withCount('students')->latest()->paginate();
        }

        return view('bands.index', compact('bands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->role === UserRole::Teacher) {
            $responsibleTeacher = auth()->user()->teacher;
            return view('bands.create', compact('responsibleTeacher'));
        }
        else if(auth()->user()->role === UserRole::Admin) {
            $teachers = Teacher::with('user')->latest()->get();
            return view('bands.create', compact('teachers'));
        }
        return redirect()->back()->with('error', 'Kapelu môže vytvoriť len admin alebo učiteľ.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BandRequest $request)
    {
        Gate::authorize('create', Band::class);
        $data = $request->validated();

        if(request()->user()->role === UserRole::Teacher) {
            if($data['teacher'] !== request()->user()->teacher->id) {
                return redirect()->back()->with('error', 'Učiteľ môže ku kapele priradiť len seba');
            }
        }

        $band = Band::create([
            'teacher_id' => $data['teacher'],
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'description' => $data['description']
        ]);

        return redirect()->route('bands.show', $band)->with('success', 'Kapela úspešne vytvorená.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        $band->load('teacher.user')
            ->withCount('students');
        return view('bands.show', compact('band'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Band $band)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BandRequest $request, Band $band)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        //
    }

    public function restore($band)
    {

    }
}
