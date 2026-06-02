<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === UserRole::Admin) {
            $departments = Department::withTrashed()->withCount('specializations')->latest()->get();
        }
        else {
            $departments = Department::withCount('specializations')->latest()->paginate();
        }

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        Gate::authorize('create', Department::class);
        $data = $request->validated();
        $department = Department::create([
            'name'=> $data['name'],
            'description' => $data['description'],
        ]);

        return redirect()->route('departments.show', $department)
            ->with('success', 'Odbor úspešne vytvorený.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        Gate::authorize('view', $department);
        $department->withCount('specializations');
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        Gate::authorize('edit', $department);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        Gate::authorize('edit', $department);
        $data = $request->validated();
        $department->update([
            'name'=> $data['name'],
            'description' => $data['description'],
        ]);
        return redirect()->route('departments.show', $department)
            ->with('success', 'Odbor úspešne upravený');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        Gate::authorize('delete', $department);
        $department->delete();
        return redirect()->route('departments.index')
            ->with('success', 'Odbor úspešne vymaazaný.');
    }

    public function restore($department) {
        $department = Department::withTrashed()->findOrFail($department);
        Gate::authorize('restore', $department);
        $department->restore();
        return redirect()->route('departments.show', $department)
            ->with('success', 'Odbor úspešne obnovený.');
    }
}
