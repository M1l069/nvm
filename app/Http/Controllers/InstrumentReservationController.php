<?php

namespace App\Http\Controllers;

use App\Enums\InstrumentReservationStatus;
use App\Enums\UserRole;
use App\Http\Requests\InstrumentReservationRequest;
use App\Models\Instrument;
use App\Models\InstrumentReservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class InstrumentReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', [InstrumentReservation::class]);
        $reservations = InstrumentReservation::with('instrument', 'reservedFor', 'reservedBy')->latest()->paginate();
        return view('instruments.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', [InstrumentReservation::class]);
        $instruments = Instrument::latest()->get();
        $users = User::where('role', '!=', UserRole::Parent->value)->latest()->get();
        return view('instruments.reservations.create', compact('instruments', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstrumentReservationRequest $request)
    {
        Gate::authorize('create', [InstrumentReservation::class]);
        $data = $request->validated();
        $from = Carbon::parse($data['from']);
        $to = Carbon::parse($data['to']);
        $instrumentConflict = InstrumentReservation::where('instrument_id', $data['instrument_id'])
            ->whereIn('status', [
                InstrumentReservationStatus::Active->value,
                InstrumentReservationStatus::Overdue->value,
            ])
            ->where('from', '<', $to)
            ->where('to', '>', $from)
            ->exists();
        if($instrumentConflict){
            return redirect()->back()
                ->with('error', 'Nástroj je v danom časovom rozmedzí požičaný alebo ešte nebol vrátený');
        }

        $reservation = InstrumentReservation::create([
            'instrument_id' => $data['instrument_id'],
            'reserved_by' => auth()->user()->id,
            'reserved_for' => $data['reserved_for'],
            'from' => $from,
            'to' => $to,
            'description' => $data['description'],
            'status' => InstrumentReservationStatus::Active->value
        ]);

        return redirect()->route('instruments-reservations.show', $reservation)
            ->with('success', 'Rezervácia úspešne vytvorená.');

    }

    /**
     * Display the specified resource.
     */
    public function show(InstrumentReservation $instruments_reservation)
    {
        Gate::authorize('view',  $instruments_reservation);
        $instruments_reservation->load(['instrument', 'reservedFor', 'reservedBy']);
        return view('instruments-reservations.show', compact('instruments_reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstrumentReservation $instruments_reservation)
    {
        Gate::authorize('update', $instruments_reservation);
        $instruments_reservation->load(['instrument', 'reservedFor', 'reservedBy']);
        $instruments = Instrument::latest()->get();
        $users = User::where('role', '!=', UserRole::Parent->value)->latest()->get();
        return view('instruments.reservations.edit', compact('instruments_reservation', 'instruments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstrumentReservationRequest $request, InstrumentReservation $instruments_reservation)
    {
        Gate::authorize('update', $instruments_reservation);
        $data = $request->validated();
        $from = Carbon::parse($data['from']);
        $to = Carbon::parse($data['to']);
        $instrumentConflict = InstrumentReservation::where('instrument_id', $data['instrument_id'])
            ->whereIn('status', [
                InstrumentReservationStatus::Active->value,
                InstrumentReservationStatus::Overdue->value,
            ])
            ->where('from', '<', $to)
            ->where('to', '>', $from)
            ->exists();
        if($instrumentConflict){
            return redirect()->back()
                ->with('error', 'Nástroj je v danom časovom rozmedzí požičaný alebo ešte nebol vrátený');
        }

        if($data['status'] === InstrumentReservationStatus::Completed){
            $instrument = Instrument::findOrFail($data['instrument_id']);
            $instrument->update([
                'is_available' => true
            ]);
        }

        $instruments_reservation->update([
            'instrument_id' => $data['instrument_id'],
            'reserved_by' => auth()->user()->id,
            'reserved_for' => $data['reserved_for'],
            'from' => $from,
            'to' => $to,
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        return redirect()->route('instruments-reservations.show', $instruments_reservation)
            ->with('success', 'Rezervácia nástroja úspešne upravená.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstrumentReservation $instruments_reservation)
    {
        Gate::authorize('delete', $instruments_reservation);
        $instrument = Instrument::findOrFail($instruments_reservation->instrument->id);
        $instrument->update([
            'is_available' => true
        ]);
        $instruments_reservation->delete();
        return redirect()->route('instruments-reservations.index')
            ->with('success', 'Rezervácia nástroja úspešne vymazaná');
    }

    public function myReservations() {
        $user = auth()->user();
        $instruments_reservations = InstrumentReservation::where('reserved_for', $user->id)->with('instrument', 'reservedFor', 'reservedBy')
            ->latest()->get();
        return view('instruments-reservations.my-reservations', compact('instruments_reservations'));
    }
}
