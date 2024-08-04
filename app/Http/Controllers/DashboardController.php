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
        $sectionId = $request->query('section_id');

        $attendanceLogs = AttendanceLog::with('student')
            ->whereDate('attendance_date', $date)
            ->whereHas('student', function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->get();

        return response()->json($attendanceLogs);
    }
}
