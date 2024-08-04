<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\Student;
use App\Rules\EmailDomain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AttendanceController extends Controller
{
    public function storeTimeIn(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', new EmailDomain],
        ]);

        try {
            $student = Student::where('email', $validated['email'])->firstOrFail();
            AttendanceLog::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => Carbon::today()],
                ['time_in' => Carbon::now(), 'time_out' => null]
            );
            return redirect()->back()->with('success', 'Time in recorded successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('failed', 'Student not found.');
        }
    }

    public function storeTimeOut(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', new EmailDomain ],
        ]);

        try {
            $student = Student::where('email', $validated['email'])->firstOrFail();
            $log = AttendanceLog::where('student_id', $student->id)
                ->whereDate('attendance_date', Carbon::today())
                ->firstOrFail();
            $log->update(['time_out' => Carbon::now()]);
            return redirect()->back()->with('success', 'Time out recorded successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('failed', 'Attendance log not found.');
        }
    }
}
