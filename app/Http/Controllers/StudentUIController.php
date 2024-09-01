<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentUIController extends Controller
{
    public function profileDetails()
    {
        $user = Auth::user();
        $student = Student::with('section', 'attendanceLogs', 'creator', 'borrowedKits')
            ->where('email', $user->email)
            ->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Student profile not found');
        }
        return view('studentinterface.profile', compact('student'));
    }
}
