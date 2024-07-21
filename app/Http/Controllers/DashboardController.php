<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function fetchAttendanceLogs(Request $request)
    {
        $date = $request->query('date');
        $attendanceLogs = AttendanceLog::whereDate('attendance_date', $date)->get();

        return response()->json($attendanceLogs);
    }
}
