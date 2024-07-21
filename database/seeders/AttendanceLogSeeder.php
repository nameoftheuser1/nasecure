<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceLog;
use App\Models\Student;
use App\Models\Instructor;
use Carbon\Carbon;

class AttendanceLogSeeder extends Seeder
{
    /**
     * Seed the attendance logs table.
     */
    public function run()
    {
        $students = Student::all();
        $instructors = Instructor::all();

        // Create attendance logs for students
        foreach ($students as $student) {
            AttendanceLog::create([
                'user_id' => $student->id,
                'user_type' => Student::class,
                'attendance_date' => Carbon::today()->subDays(rand(1, 10)),
            ]);
        }

        // Create attendance logs for instructors
        foreach ($instructors as $instructor) {
            AttendanceLog::create([
                'user_id' => $instructor->id,
                'user_type' => Instructor::class,
                'attendance_date' => Carbon::today()->subDays(rand(1, 10)),
            ]);
        }
    }
}
