<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecializationRequest;
use App\Models\Department;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Specialization::class);
        $specializations = Specialization::with('department')
            ->withCount('students')->latest()->paginate();
        return view('specializations.index', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Specialization::class);
        $departments = Department::latest()->get();
        return view('specializations.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecializationRequest $request)
    {
        Gate::authorize('create', Specialization::class);
        $data = $request->validated();
        $specialization = Specialization::create([
            'name' => $data['name'],
            'department_id' => $data['department_id'],
        ]);
        return redirect()->route('specializations.show', $specialization);
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        $specialization->load('department.responsibleTeacher.user');
        return view('specializations.show', compact('specialization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization  $specialization)
    {
        $departments = Department::latest()->get();
        return view('specializations.edit', compact('specialization', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        Gate::authorize('update', $specialization);
        $data = $request->validated();

        $specialization->update([
            'name' => $data['name'],
            'department_id' => $data['department_id'],
        ]);

        return redirect()->route('specializations.show', $specialization)
            ->with('success', 'Špecializcia úspešne upravená.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        Gate::authorize('delete', $specialization);
        $specialization->delete();
        return redirect()->route('specializations.index')
            ->with('success', 'Špecializácia úspešne vymazaná.');
    }

    public function restore($specialization)
    {
        $specialization = Specialization::withTrashed()->findOrFail($specialization);
        Gate::authorize('restore', $specialization);
        $specialization->restore();
        if($specialization->department()->withTrashed()->exists()) {
            $specialization->department()->first()->restore();
        }

        return redirect()->route('specializations.show', $specialization)
            ->with('success', 'Špecualizácia úspešne obnovená.');
    }
}
