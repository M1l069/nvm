<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\EventRequest;
use App\Models\Band;
use App\Models\Event;
use App\Models\Room;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use League\ISO3166\ISO3166;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $events = Event::with([
            'participants',
            'room',
            'bands',
            'responsibleTeacher.user',
        ])
            ->withCount('participants')
            ->latest();

        if ($user->role === UserRole::Student) {
            $student = $user->student;

            if (! $student) {
                abort(403);
            }

            $studentBandIds = $student->bands()->pluck('bands.id');

            $events->where(function ($query) use ($user, $studentBandIds) {
                $query->whereHas('participants', function ($participantQuery) use ($user) {
                    $participantQuery->where('users.id', $user->id);
                })
                    ->orWhereHas('bands', function ($bandQuery) use ($studentBandIds) {
                        $bandQuery->whereIn('bands.id', $studentBandIds);
                    });
            });
        }

        if ($user->role === UserRole::Teacher) {
            $teacher = $user->teacher;

            if (! $teacher) {
                abort(403);
            }

            $events->where(function ($query) use ($user, $teacher) {
                $query->whereHas('participants', function ($participantQuery) use ($user) {
                    $participantQuery->where('users.id', $user->id);
                })
                    ->orWhereHas('bands', function ($bandQuery) use ($teacher) {
                        $bandQuery->where('bands.teacher_id', $teacher->id);
                    })
                    ->orWhere('teacher_id', $teacher->id);
            });
        }

        if ($user->role === UserRole::Parent) {
            $guardian = $user->guardian;

            if (! $guardian) {
                abort(403);
            }

            $children = $guardian->students()->get();

            $childrenUserIds = $children->pluck('user_id');
            $childrenStudentIds = $children->pluck('id');

            $childrenBandIds = Band::whereHas('students', function ($query) use ($childrenStudentIds) {
                $query->whereIn('students.id', $childrenStudentIds);
            })->pluck('bands.id');

            $events->where(function ($query) use ($user, $childrenUserIds, $childrenBandIds) {
                $query
                    // guardian je priamo prihlásený na event
                    ->whereHas('participants', function ($participantQuery) use ($user) {
                        $participantQuery->where('users.id', $user->id);
                    })

                    // dieťa guardiana je priamo prihlásené na event
                    ->orWhereHas('participants', function ($participantQuery) use ($childrenUserIds) {
                        $participantQuery->whereIn('users.id', $childrenUserIds);
                    })

                    // dieťa guardiana je v kapele, ktorá vystupuje na evente
                    ->orWhereHas('bands', function ($bandQuery) use ($childrenBandIds) {
                        $bandQuery->whereIn('bands.id', $childrenBandIds);
                    });
            });
        }

        // Admin nič nefiltruje, vidí všetko.

        $events = $events->paginate();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::latest()->get();
        $bands = Band::latest()->get();
        $teachers = Teacher::with('user')->latest()->get();
        if (auth()->user()->role === UserRole::Teacher) {
            $teachers = Teacher::with('user')
                ->where('user_id', auth()->id())
                ->get();
        }
        $countries = __('countries');
        return view('events.create', compact('rooms', 'bands', 'teachers', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        if ($user->role === UserRole::Teacher) {
            $teacher = $user->teacher;
            if (!$teacher) {
                abort(403, 'Nemáte učiteľské konto');
            }
            if((int)$data['teacher'] !== $teacher->id) {
                return redirect()->back()->with('error',
                    'Novú udalosť môže pridať len učiteľ, ktorý je za ňu zodpovedný');
            }
        }

        $data['room'] ? $room = Event::where('room_id', $data['room'])->first() : $room = null; ;

        $event = Event::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'teacher_id' => $data['teacher'],
            'type' => $data['type'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'room_id' => $data['room'],
            'street' => $data['street'],
            'postal_code' => $data['postal_code'],
            'city' => $data['city'],
            'country' => $data['country'],
            'capacity' => $data['room'] ? $room->capacity : $data['capacity'],
            'is_public' => $data['is_public'],
        ]);

        $event->bands()->sync($data['band']);

        return redirect()->route('events.show', $event)
            ->with('success', 'Udalosť úspešne vytvorená.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        Gate::authorize('view', $event);
        $event->load('participants', 'room', 'bands.teacher.user');
        $participantsCount = $event->participants->count();
        return view('events.show', compact('event', 'participantsCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $rooms = Room::latest()->get();
        $bands = Band::latest()->get();
        $teachers = Teacher::with('user')->latest()->get();
        if (auth()->user()->role === UserRole::Teacher) {
            $teachers = Teacher::with('user')
                ->where('user_id', auth()->id())
                ->get();
        }
        $countries = __('countries');
        return view('events.edit', compact('rooms', 'bands', 'teachers', 'countries'));
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
