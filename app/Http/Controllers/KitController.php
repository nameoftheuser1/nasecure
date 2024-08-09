<?php

namespace App\Http\Controllers;

use App\Models\Kit;
use App\Models\Student;
use Illuminate\Http\Request;

class KitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kits = Kit::query()
            ->where('kit_name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('kits.index', ['kits' => $kits]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'kit_name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        Kit::create($fields);

        return redirect()->route('kits.index')->with('success', 'Kit added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kit $kit)
    {
        $borrowedKits = $kit->borrowedKits()->latest()->paginate(10);

        $students = Student::whereIn('id', $kit->borrowedKits->pluck('student_id'))->get();

        return view('kits.show', [
            'kit' => $kit,
            'borrowedKits' => $borrowedKits,
            'students' => $students,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kit $kit)
    {
        return view('kits.edit', compact('kit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kit $kit)
    {
        $fields = $request->validate([
            'kit_name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $kit->update($fields);

        return redirect()->route('kits.index')->with('success', 'Kit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kit $kit)
    {
        $kit->delete();

        return redirect()->route('kits.index')->with('deleted', 'Kit deleted successfully.');
    }
}
