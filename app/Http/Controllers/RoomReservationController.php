<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\RoomReservationRequest;
use App\Models\Event;
use App\Models\Room;
use App\Models\RoomReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class RoomReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Room $room)
    {
        Gate::authorize('viewAny', RoomReservation::class);

        $roomReservations = RoomReservation::where(
            'room_id', $room->id
        )->with('reservedBy.user')->latest()->get();

        return view('rooms.reservations.index', compact('room', 'roomReservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Room $room)
    {
        Gate::authorize('create', RoomReservation::class);
        $user = auth()->user();
        if($user->role === UserRole::Admin || $user->role === UserRole::Teacher) {
            return view('rooms.reservations.create', compact('room'));
        }
        else {
            return redirect()->back()
                ->with('error', 'Rezerváciu miestnosti môže vytvoriť iba admin alebo učiteľ');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomReservationRequest $request, Room $room)
    {
        $data = $request->validated();
        if (! $room) {
            return redirect()->route('rooms.reservations.index', $room)
                ->with('error', 'Miestnosť neexistuje.');
        }

        $from = Carbon::parse($data['from']);
        $to = Carbon::parse($data['to']);

        $reservationConflict = RoomReservation::where('room_id', $room->id)
            ->where('from', '<', $to)
            ->where('to', '>', $from)
            ->exists();

        $eventConflict = Event::where('room_id', $room->id)
            ->where('starts_at', '<', $to)
            ->where('ends_at', '>', $from)
            ->exists();

        if ($reservationConflict || $eventConflict) {
            return redirect()->back()->with('error', 'Miestnosť je v zadanom čase už obsadená.');
        }

        $reservation = RoomReservation::create([
            'room_id' => $room->id,
            'reserved_by' => auth()->user()->id,
            'from' => $from,
            'to' => $to,
            'description' => $data['description'],
            'status' => true
        ]);

        return redirect()
            ->route('rooms.reservations.show', [$room, $reservation])
            ->with('success', 'Rezervácia miestnosti bola úspešne vytvorená.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room, RoomReservation $reservation)
    {
        Gate::authorize('view', $reservation);
        $user = auth()->user();
        $reservation->load('reservedBy');
        return view('rooms.reservations.show', compact('room', 'reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room, RoomReservation $reservation)
    {
        Gate::authorize('update', $reservation);
        return view('rooms.reservations.edit', compact('room', 'reservation'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomReservationRequest $request, Room $room, RoomReservation $reservation)
    {
        Gate::authorize('update', $reservation);
        $data = $request->validated();
        if (! $room) {
            return redirect()->route('rooms.reservations.index', $room)
                ->with('error', 'Miestnosť neexistuje.');
        }

        $from = Carbon::parse($data['from']);
        $to = Carbon::parse($data['to']);

        $reservationConflict = RoomReservation::where('room_id', $room->id)
            ->where('id', '!=', $reservation->id)
            ->where('from', '<', $to)
            ->where('to', '>', $from)
            ->exists();

        $eventConflict = Event::where('room_id', $room->id)
            ->where('starts_at', '<', $to)
            ->where('ends_at', '>', $from)
            ->exists();

        if ($reservationConflict || $eventConflict) {
            return redirect()->back()->with('error', 'Miestnosť je v zadanom čase už obsadená.');
        }

        $reservation->update([
           'room_id' => $room->id,
            'from' => $from,
            'to' => $to,
            'description' => $data['description'],
            'status' => true
        ]);

        return redirect()->route('rooms.reservations.show', [$room, $reservation])
            ->with('success', 'Rezervácia miestnosti úspešne upravená');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room, RoomReservation $reservation)
    {
        Gate::authorize('delete', $reservation);
        $reservation->delete();
        return redirect()->route('rooms.reservations.index', compact('room'))
            ->with('success', 'Rezervácie úspešne zrušená');
    }
}
