<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $events = Event::with(['room', 'bands', 'responsibleTeacher.user'])
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->latest()->paginate();
        return view('events.participants.index', compact('events'));
    }

    /**
     * Show participants for the event.
     */
    public function show(Event $event) {
        $user = auth()->user();
        if($user->role === UserRole::Admin) {
            $participants =  $event->participants()->latest()->get();
            return view('events.participants.show', compact('event', 'participants'));
        }

        else if($user->role === UserRole::Teacher) {
            if($user->teacher->id === $event->teacher_id ||  $event->bands->contains('teacher_id', $user->teacher->id)) {
                $participants = $event->participants()->latest()->get();
                return view('events.participants.show', compact('event', 'participants'));
            }
        }
        return redirect()->back()
            ->with('error',
                'Zoznam zúčastnených si môže prezrieť len zodpovedný učiteľ za udalosť,
                 admin alebo učiteľ, ktorý vedie vystupujúcu kapelu');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $user = $request->user();
        if(!$event->is_public) {
            return redirect()->back()
                ->with('error', 'Nemôžete sa prihlásiť na neverejnú udalosť');
        }

        if ($event->participants()->where('users.id', $user->id)->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Na túto udalosť ste už prihlásený.');
        }

        if($event->participants->count() >= $event->capacity) {
            return redirect()->back()->with('error', 'Udalosť má plnú kapacitu');
        }

        $event->participants()->attach($user->id);
        return redirect()->back()->with('success', 'Úspešne ste sa prihlásili na udalosť ' . $event->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();

        if(!$event->participants()->where('users.id', $user->id)->exists()) {
            return redirect()->back()
                ->with('error', 'Nemôžete sa odhlásiť z udalosti, na ktorú nie ste prihlásený');
        }

        $event->participants()->detach($user->id);

        return redirect()->back()->with('success', 'Úspešne ste sa odhlásili z udalosti');
    }

    public function destroyParticipant(Event $event, User $user) {
        $authUser = auth()->user();

        if($authUser->role === UserRole::Admin) {
            $event->participants()->detach($user->id);
            return redirect()->back()->with('success', 'Účastník odstránený z udalosti');
        }

        if($authUser->role === UserRole::Teacher) {
            if($authUser->teacher->id === $event->teacher_id) {
                $event->participants()->detach($user);
                return redirect()->back()->with('success', 'Účastník odstránený z udalosti');
            }
        }

        return redirect()->back()->with('error', 'Účastníka môže odstrániť z udalosti len admin alebo učiteľ zodpovedný za udalosť');
    }
}
