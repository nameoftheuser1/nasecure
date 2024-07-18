<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Program;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::query()
            ->join('programs', 'courses.program_id', '=', 'programs.id')
            ->where('programs.program_code', 'like', "%{$search}%")
            ->orWhere('courses.course_name', 'like', "%{$search}%")
            ->select('courses.*', 'programs.program_code')
            ->latest()
            ->paginate(10);

        return view('courses.index', ['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        return view('courses.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'course_name' => ['required', 'max:100'],
        ]);

        Course::create($fields);

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $programs = Program::all();
        return view('courses.edit', compact('course', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $fields = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'course_name' => ['required', 'max:100'],
        ]);

        $course->update($fields);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('deleted', 'Course deleted successfully.');
    }
}
