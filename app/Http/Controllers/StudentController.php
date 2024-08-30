<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Section;
use App\Rules\EmailDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $studentsQuery = Student::with('section');

        if ($user->role->name !== 'admin') {
            $studentsQuery->where('created_by', $user->id);
        }

        $students = $studentsQuery->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('student_id', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('rfid', 'like', "%{$search}%")
                ->orWhere('section_id', 'like', "%{$search}%");
        })
            ->orderBy($sort, $direction)
            ->oldest()
            ->paginate(10);


        return view('students.index', ['students' => $students]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role->name !== 'admin') {
            $sections = Section::where('created_by', $user->id)->get();
        } else {
            $sections = Section::all();
        }

        return view('students.create', compact('sections'));
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
            'section_id' => ['nullable', 'string', 'max:50'],
        ]);

        $fields['created_by'] = Auth::id();

        Student::create($fields);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $sections = Section::all();
        $attendanceLogs = $student->attendanceLogs()->latest()->paginate(10);

        return view('students.show', [
            'student' => $student,
            'sections' => $sections,
            'attendanceLogs' => $attendanceLogs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $user = auth()->user();

        if ($user->role->name !== 'admin') {
            $sections = Section::where('created_by', $user->id)->get();
        } else {
            $sections = Section::all();
        }

        return view('students.edit', compact('student', 'sections'));
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
            'section_id' => ['nullable', 'string', 'max:50'],
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

        try {
            $file = $request->file('file');

            Log::info('File received: ' . $file->getClientOriginalName());

            (new FastExcel)->import($file, function ($line) {
                Student::updateOrCreate(
                    ['student_id' => $line['Student ID']],
                    [
                        'name' => $line['Name'] ?? null,
                        'email' => $line['Email'] ?? null,
                        'rfid' => $line['RFID'] ?? null,
                        'section_id' => $line['Section ID'] ?? null,
                        'created_by' => Auth::id(),
                    ]
                );
            });

            return redirect()->route('students.index')->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            $msg = Log::error('Error importing students: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error importing the students. Please check the file and try again.' . $msg);
        }
    }
}
