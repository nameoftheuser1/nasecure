<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sections = Section::query()
            ->where('section_name', 'like', "%{$search}%")
            ->orWhere('student_count', 'like', "%{$search}%")
            ->orWhereHas('instructor', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('course', function ($query) use ($search) {
                $query->where('course_name', 'like', "%{$search}%");
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
        $instructors = Instructor::all();
        $courses = Course::all();
        return view('sections.create', compact('instructors', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $fields = $request->validate([
            'section_name' => ['required', 'max:50'],
            'student_count' => ['required', 'integer'],
            'instructor_id' => ['required', 'exists:instructors,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
