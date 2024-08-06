<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Http\Requests\StoreAttendanceLogRequest;
use App\Http\Requests\UpdateAttendanceLogRequest;
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
        $user = Auth::user();

        $attendanceLogsQuery = AttendanceLog::with('student', 'section')
            ->when($user->role->name !== 'admin', function ($query) use ($user) {
                $query->whereHas('student', function ($query) use ($user) {
                    $query->where('created_by', $user->id);
                });
            })
            ->where(function ($query) use ($search) {
                $query->whereHas('student', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('attendance_date', 'like', "%{$search}%")
                    ->orWhere('time_in', 'like', "%{$search}%")
                    ->orWhere('time_out', 'like', "%{$search}%")
                    ->orWhereHas('section', function ($query) use ($search) {
                        $query->where('subject', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('attendance_logs.index', ['attendanceLogs' => $attendanceLogsQuery]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceLog $attendanceLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceLog $attendanceLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceLogRequest $request, AttendanceLog $attendanceLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceLog $attendanceLog)
    {
        //
    }
}
