<?php

namespace App\Http\Controllers\Home;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Band;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        if(request()->user()->role === UserRole::Admin) {
            $bands = Band::with(['events.room'])->latest()->get();

            $userEvents = Event::with([
                'room'])->whereHas('participants')->orderBy('starts_at')->get();

            return view('welcome', compact('user','bands', 'userEvents'));
        }

        else if(request()->user()->role === UserRole::Student) { // ešte načítanie gradeEventov a známok
            $user = $user->load([
                'student.specialization',
                'student.bands.events' => fn ($q)
                => $q->where('starts_at', '>=', now())->orderBy('starts_at'),
                'student.bands.events.room',
                'student.user.events' => fn ($q) =>
                $q->where('starts_at', '>=', now())->orderBy('starts_at'),
                'student.user.events.room'
            ]);
            return view('welcome', compact('user'));
        }
        else if(request()->user()->role === UserRole::Teacher) {
            $user = $user->load([
                'teacher.bands.events' => fn ($q)
                => $q->where('starts_at', '>=', now())->orderBy('starts_at'),
                'teacher.bands.events.room',
                'teacher.user.events' => fn ($q) =>
                $q->where('starts_at', '>=', now())->orderBy('starts_at'),
                'teacher.user.events.room'
            ]);
            return view('welcome', compact('user'));
        }
        else if(request()->user()->role === UserRole::Parent) {  // ešte načítanie gradeEventov a známok
            $user = $user->load([
                'guardian.students.specialization' ,
                'guardian.students.bands.events' => fn ($query) =>
                $query->where('starts_at', '>=', now())
                    ->orderBy('starts_at'),
                'guardian.students.bands.events.room',
                'guardian.user.events' => fn ($query) =>
                $query->where('starts_at', '>=', now())->orderBy('starts_at'),
                'guardian.user.events.room']);
            return view('welcome', compact('user'));
        }
        else { return view('welcome');}
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
