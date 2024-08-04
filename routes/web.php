<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/attendance', 'attendance.attendance')->name('attendance');
    Route::post('/attendance/time-in', [AttendanceController::class, 'storeTimeIn'])->name('attendance.timeIn');
    Route::post('/attendance/time-out', [AttendanceController::class, 'storeTimeOut'])->name('attendance.timeOut');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', 'dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/attendance-logs', [DashboardController::class, 'fetchAttendanceLogs']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::resource('students', StudentController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('attendance_logs', AttendanceLogController::class);

    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('instructors/import', [InstructorController::class, 'import'])->name('instructors.import');

    Route::middleware('admin')->group(function () {
        Route::get('/users', [AuthController::class, 'index'])->name('users');
    });
});


Route::fallback(function () {
    return redirect('/');
});
