<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instructors = Instructor::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('pin_code', 'like', "%{$search}%")
            ->orWhere('rfid', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('instructors.index', ['instructors' => $instructors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pin_code' => ['nullable', 'integer', 'max:10', 'unique:instructors,pin_code'],
            'rfid' => ['nullable', 'string', 'max:50'],
        ]);

        Instructor::create($fields);

        return redirect()->route('instructors.index')->with('success', 'Instructor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        $instructor->load('sections');
        return view('instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pin_code' => ['required', 'integer', 'max:10'],
            'rfid' => ['nullable', 'string', 'max:50'],
        ]);

        $instructor->update($fields);

        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        $instructor->delete();

        return back()->with('deleted', 'The instructor is deleted');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');

        $instructors = (new FastExcel)->import($file, function ($line) {
            return Instructor::create([
                'name' => $line['Name'],
                'pin_code' => $line['Pin Code'],
                'rfid' => $line['RFID'],
            ]);
        });

        return redirect()->route('instructors.index')->with('success', 'Instructors imported successfully.');
    }
}
