<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['participants', 'room', 'bands'])->latest()
            ->paginate();
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $room = Room::latest()->get();
        $bands = Band::latest()->get();
        return view('events.create', compact('room', 'bands'));
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
    public function show(Event $event)
    {
        $event->load('participants', 'room', 'bands');
        $participantsCount = $event->participants->count();
        return view('events.show', compact('event', 'participantsCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {

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
