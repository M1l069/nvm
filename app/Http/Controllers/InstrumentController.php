<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentRequest;
use App\Models\Instrument;
use App\Models\Room;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Instrument::class);
        $instruments = Instrument::with('specialization', 'room')->latest()->paginate();
        return view('instruments.index', compact('instruments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Instrument::class);
        $specializations = Specialization::latest()->get();
        $rooms = Room::latest()->get();
        return view('instruments.create', compact('specializations', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstrumentRequest $request)
    {
        Gate::authorize('create', Instrument::class);
        $data = $request->validated();
        $instrument = Instrument::create([
            'manufacturer' => $data['manufacturer'],
            'model_name' => $data['model_name'],
            'serial_number' => $data['serial_number'],
            'specialization_id' => $data['specialization_id'],
            'room_id' => $data['room_id'],
            'is_available' => true
        ]);
        return redirect()->route('instruments.show', $instrument)
            ->with('success', 'Nástroj úspešne pridanný.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument)
    {
        Gate::authorize('view', $instrument);
        $instrument->load('specialization', 'room');
        return view('instruments.show', compact('instrument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instrument $instrument)
    {
        Gate::authorize('update', $instrument);
        $instrument->load('specialization', 'room');
        $specializations = Specialization::latest()->get();
        $rooms = Room::latest()->get();
        return view('instruments.edit', compact('instrument', 'specializations', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstrumentRequest $request, Instrument $instrument)
    {
        Gate::authorize('update', $instrument);
        $data = $request->validated();
        $instrument->update([
            'manufacturer' => $data['manufacturer'],
            'model_name' => $data['model_name'],
            'serial_number' => $data['serial_number'],
            'specialization_id' => $data['specialization_id'],
            'room_id' => $data['room_id'],
            'is_available' => true
        ]);

        return redirect()->route('instruments.show', $instrument)
            ->with('success', 'Nástroj úspešne upravený');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instrument $instrument)
    {
        Gate::authorize('delete', $instrument);
        $instrument->delete();
        return redirect()->route('instruments.index')
            ->with('success', 'Nástroj úspešne upravený');
    }
}
