<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\Student;
use App\Models\Section;
use App\Rules\EmailDomain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AttendanceController extends Controller
{
    public function storeTimeIn(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', new EmailDomain],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        try {
            $student = Student::where('email', $validated['email'])->firstOrFail();
            AttendanceLog::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => Carbon::today()],
                ['time_in' => Carbon::now(), 'time_out' => null, 'section_id' => $validated['section_id']]
            );
            return redirect()->back()->with('success', 'Time in recorded successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('failed', 'Student not found.');
        }
    }

    public function storeTimeOut(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', new EmailDomain],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        try {
            $student = Student::where('email', $validated['email'])->firstOrFail();
            $log = AttendanceLog::where('student_id', $student->id)
                ->whereDate('attendance_date', Carbon::today())
                ->where('section_id', $validated['section_id'])
                ->firstOrFail();
            $log->update(['time_out' => Carbon::now()]);
            return redirect()->back()->with('success', 'Time out recorded successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('failed', 'Attendance log not found.');
        }
    }

    public function fetchSections(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', new EmailDomain],
        ]);

        try {
            $student = Student::where('email', $validated['email'])->firstOrFail();
            $section = $student->section;

            return response()->json([
                'sections' => $section ? [$section] : [],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Student not found.',
            ], 404);
        }
    }
}
