<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $programs = Program::query()
            ->where('program_name', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('programs.index', ['programs' => $programs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'program_name' => ['required', 'max:50'],
        ]);

        Program::create($fields);

        return redirect()->route('programs.index')->with('success', 'Program added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $fields = $request->validate([
            'program_name' => ['required', 'max:50'],
        ]);

        $program->update($fields);

        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')->with('deleted', 'Program deleted successfully.');
    }
}
