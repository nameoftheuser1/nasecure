<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\Student;
use App\Models\Section;
use App\Rules\EmailDomain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

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

    /**
     * MUST READ!!
     *
     * This code is a Laravel controller action that handles RFID scanning in a student attendance system.
     * It can be integrated with an Arduino Mega board to create a physical RFID-based attendance system.
     *
     * The Arduino Mega can be used to read RFID tags and send the RFID data to the Laravel application
     * through a serial connection or a network connection (e.g., Ethernet or WiFi).
     *
     * Here's an example of how you can use this code with an Arduino Mega:
     *
     * 1. Connect an RFID reader module (e.g., MFRC522) to the Arduino Mega.
     * 2. Write Arduino code to read the RFID tag data and send it to the Laravel application
     *    through a serial connection or a network connection.
     * 3. In the Arduino code, when an RFID tag is detected, send the RFID tag data to the Laravel application
     *    by making an HTTP POST request to the `scanRFID` endpoint.
     * 4. The Laravel application will then process the RFID data, look up the student, check the current section,
     *    and update the attendance log accordingly.
     * 5. The Laravel application can then send a response back to the Arduino Mega, which can be used to trigger
     *    a buzzer or some other output based on the attendance status (e.g., successful check-in, check-out, or error).
     *
     */

    public function scanRFID(Request $request)
    {
        $validated = $request->validate([
            'rfid' => ['required', 'string'],
        ]);

        try {
            $student = Student::where('rfid', $validated['rfid'])->firstOrFail();
            $currentTime = Carbon::now();
            $section = Section::where('time_in', '<=', $currentTime)
                ->where('time_out', '>=', $currentTime)
                ->first();

            if (!$section) {
                Log::warning('No section registered at this time. Buzzer output triggered.');
                return response()->json([
                    'error' => 'No section registered at this time. Buzzer output triggered.',
                ], 404);
            }

            $attendanceLog = AttendanceLog::where('student_id', $student->id)
                ->where('section_id', $section->id)
                ->whereDate('attendance_date', $currentTime)
                ->first();

            if ($attendanceLog) {
                Log::warning('Attendance already recorded for Section ' . $section->id . ' today.');
                return response()->json([
                    'error' => 'Attendance already recorded for Section ' . $section->id . ' today.',
                ], 400);
            } else {
                $attendanceLog = AttendanceLog::create([
                    'student_id' => $student->id,
                    'section_id' => $section->id,
                    'attendance_date' => $currentTime,
                    'time_in' => $currentTime,
                ]);
                Log::info('Attendance recorded successfully for Section ' . $section->id);
                return response()->json([
                    'success' => 'Attendance recorded successfully for Section ' . $section->id,
                ]);
            }
        } catch (ModelNotFoundException $e) {
            Log::warning('RFID not recognized. Buzzer output triggered.');
            return response()->json([
                'error' => 'RFID not recognized. Buzzer output triggered.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('An error occurred while processing the RFID scan: ' . $e->getMessage());
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
}
