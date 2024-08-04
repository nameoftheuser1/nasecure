<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\Student;
use App\Models\Instructor;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function recordAttendance(Request $request)
    {
        $rfid = $request->input('rfid');
        $classSessionId = $request->input('class_session_id');

        $student = Student::where('rfid', $rfid)->first();
        $instructor = Instructor::where('rfid', $rfid)->first();

        if (!$student && !$instructor) {
            return response()->json(['message' => 'RFID not recognized'], 404);
        }

        $user = $student ?: $instructor;
        $userId = $user->id;

        AttendanceLog::create([
            'class_session_id' => $classSessionId,
            'user_id' => $userId,
            'attendance_date' => Carbon::now(),
            'status' => 'present'
        ]);

        return response()->json(['message' => 'Attendance recorded successfully']);
    }
}
