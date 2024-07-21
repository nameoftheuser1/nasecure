<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function fetchAttendanceLogs(Request $request)
    {
        $date = $request->query('date');
        $attendanceLogs = AttendanceLog::with('student')
            ->whereDate('attendance_date', $date)
            ->get();

        return response()->json($attendanceLogs);
    }
}
