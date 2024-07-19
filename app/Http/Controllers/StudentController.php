<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Course;
use App\Rules\EmailDomain;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $students = Student::with('course')
            ->where('name', 'like', "%{$search}%")
            ->orWhere('student_id', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('rfid', 'like', "%{$search}%")
            ->orWhere('course_id', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50', 'unique:students,student_id'],
            'email' => ['required', 'email', 'unique:students,email', new EmailDomain],
            'rfid' => ['nullable', 'string', 'max:50'],
            'course_id' => ['nullable', 'string', 'max:50'],
        ]);

        Student::create($fields);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50', 'unique:students,student_id,' . $student->id],
            'email' => ['required', 'email', 'unique:students,email,' . $student->id, new EmailDomain],
            'rfid' => ['nullable', 'string', 'max:50'],
            'course_id' => ['nullable', 'string', 'max:50'],
        ]);

        $student->update($fields);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('deleted', 'The student is deleted');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');

        $students = (new FastExcel)->import($file, function ($line) {
            return Student::create([
                'name' => $line['Name'],
                'student_id' => $line['Student ID'],
                'email' => $line['Email'],
                'rfid' => $line['RFID'],
                'course_id' => $line['Course ID'],
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Students imported successfully.');
    }
}
