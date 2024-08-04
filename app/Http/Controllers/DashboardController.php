<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Section;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sections = Section::with('students')
            ->where('sections.section_name', 'like', "%{$search}%")
            ->select('sections.*')
            ->latest()
            ->paginate(10);

        return view('dashboard.index', ['sections' => $sections]);
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
