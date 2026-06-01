<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Room::class);
        $rooms = Room::with('events.room', 'roomReservations')->latest()->paginate();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Room::class);
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        Gate::authorize('create', Room::class);
        $data = $request->validated();
        $room = Room::create([
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'description' => $data['description'],
        ]);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Miestnosť úspešne vytvorená.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        Gate::authorize('view', $room);
        $room->load([
            'events.responsibleTeacher.user',
            'roomReservations.reservedBy',
        ]);


        $activeEvent = $room->events()
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->with('responsibleTeacher.user')
            ->first();

        $activeReservation = $room->roomReservations()
            ->where('from', '<=', now())
            ->where('to', '>=', now())
            ->with('reservedBy')
            ->first();

        $isReserved = $activeEvent || $activeReservation;

        return view('rooms.show', compact(
            'room',
            'activeEvent',
            'activeReservation',
            'isReserved'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        Gate::authorize('update', $room);
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        Gate::authorize('update', $room);
        $data = $request->validated();

        $room->update([
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'description' => $data['description'],
        ]);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Miestnosť úspešne upravená.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
