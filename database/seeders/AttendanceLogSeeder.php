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

        foreach ($students as $student) {
            AttendanceLog::create([
                'user_id' => $student->id,
                'attendance_date' => Carbon::today()->subDays(rand(1, 10)),
            ]);
        }

    }
}
