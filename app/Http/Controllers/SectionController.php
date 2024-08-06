<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userId = Auth::id();
        $sections = Section::with('course')
            ->where('created_by', $userId)
            ->where(function ($query) use ($search) {
                $query->where('section_name', 'like', "%{$search}%")
                    ->orWhere('student_count', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('course_id', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($query) use ($search) {
                        $query->where('course_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('sections.index', ['sections' => $sections]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('sections.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'section_name' => ['required', 'max:50'],
            'student_count' => ['required', 'integer'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'subject' => ['required', 'string', 'max:100'],
        ]);

        $fields['created_by'] = Auth::id();

        Section::create($fields);

        return redirect()->route('sections.index')->with('success', 'Section added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {

        $courses = Course::all();

        return view('sections.edit', compact('section', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $fields = $request->validate([
            'section_name' => ['required', 'max:50'],
            'student_count' => ['required', 'integer'],
            'instructor_id' => ['required', 'exists:instructors,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $section->update($fields);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return back()->with('deleted', 'The section is deleted');
    }
}
