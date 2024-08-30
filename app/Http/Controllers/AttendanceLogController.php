<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Http\Requests\StoreAttendanceLogRequest;
use App\Http\Requests\UpdateAttendanceLogRequest;
use App\Models\Section;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userId = Auth::id();
        $sections = Section::with('course')
            ->where('created_by', $userId)
            ->where(function ($query) use ($search) {
                $query->where('section_name', 'like', "%{$search}%")
                    ->orWhere('student_count', 'like', "%{$search}%")
                    ->orWhere('course_id', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($query) use ($search) {
                        $query->where('course_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('attendance_logs.index', ['sections' => $sections]);
    }

    public function show(Request $request, $id)
    {
        $section = Section::with(['attendanceLogs.student'])->findOrFail($id);

        $attendanceByDate = $section->attendanceLogs
            ->groupBy(function ($log) {
                return $log->created_at->format('Y-m-d');
            });

        return view('attendance_logs.show', [
            'section' => $section,
            'attendanceByDate' => $attendanceByDate,
        ]);
    }

    public function attendanceByDate(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['logs' => [], 'date' => $date, 'studentCount' => $section->student_count, 'present' => 0]);
        }

        $attendanceLogs = $section->attendanceLogs()
            ->with('student')
            ->whereDate('created_at', $date)
            ->get();

        $presentCount = $attendanceLogs->where('present', true)->count();

        return response()->json([
            'logs' => $attendanceLogs,
            'date' => $date,
            'studentCount' => $section->student_count,
            'present' => $presentCount,
        ]);
    }

    public function generatePdf(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $date = $request->query('date');
        if (!$date) {
            Log::warning('No date selected for PDF generation');
            return redirect()->back()->with('error', 'No date selected.');
        }
        $attendanceLogs = $section->attendanceLogs()
            ->with('student')
            ->whereDate('created_at', $date)
            ->get();

        try {

            $pdf = PDF::loadView('attendance_logs.pdf', [
                'section' => $section,
                'date' => $date,
                'attendanceLogs' => $attendanceLogs,
            ]);

            $filename = 'attendance-logs-' . $date . '.pdf';
            $pdfContent = $pdf->output();

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}
