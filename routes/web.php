<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowedKitController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\KitController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/resetpasswordguide', 'auth.resetpassword')->name('resetpasswordguide');
    Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/password/reset', function (Request $request) {
        return view('auth.reset')->with('token', $request->token);
    })->name('password.reset');

    Route::view('/attendance', 'attendance.attendance')->name('attendance');
    Route::post('/attendance/time-in', [AttendanceController::class, 'storeTimeIn'])->name('attendance.timeIn');
    Route::post('/attendance/time-out', [AttendanceController::class, 'storeTimeOut'])->name('attendance.timeOut');
    Route::post('/fetch-sections', [AttendanceController::class, 'fetchSections'])->name('attendance.fetchSections');
    Route::post('/attendance/scan-rfid', [AttendanceController::class, 'scanRFID'])->name('attendance.scan-rfid');
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
    Route::resource('sections', SectionController::class);
    Route::resource('attendance_logs', AttendanceLogController::class);

    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');


    Route::middleware('admin')->group(function () {
        Route::get('/users', [AuthController::class, 'index'])->name('users');
        Route::post('/users/{user}/reset-password', [AuthController::class, 'resetPassword'])->name('users.resetPassword');
        Route::post('instructors/import', [InstructorController::class, 'import'])->name('instructors.import');
        Route::resource('instructors', InstructorController::class);
        Route::resource('kits', KitController::class);
        Route::get('/borrowed-kits', [BorrowedKitController::class, 'index'])->name('borrowed-kits');
        Route::get('/borrowed-kits/borrow', [BorrowedKitController::class, 'borrow'])->name('borrowed-kits.borrow');
        Route::get('/borrowed-kits/cart', [BorrowedKitController::class, 'viewCart'])->name('borrowed-kits.cart');
        Route::post('/borrowed-kits/add-to-cart', [BorrowedKitController::class, 'addToCart'])->name('borrowed-kits.addToCart');
        Route::post('/borrowed-kits/remove-from-cart/{kitId}', [BorrowedKitController::class, 'removeFromCart'])->name('borrowed-kits.removeFromCart');
        Route::post('/borrowed-kits/proceed-to-borrow', [BorrowedKitController::class, 'proceedToBorrow'])->name('borrowed-kits.proceedToBorrow');
        Route::get('/borrowed-kits/return', [BorrowedKitController::class, 'showReturnForm'])->name('borrowed-kits.return');
        Route::post('/borrowed-kits/return', [BorrowedKitController::class, 'processReturn'])->name('borrowed-kits.return.process');
        Route::get('/borrowed-kits/fetch-borrowed-kits', [BorrowedKitController::class, 'fetchBorrowedKits']);
        Route::post('/borrowed-kits/return', [BorrowedKitController::class, 'returnKits'])->name('borrowed-kits.return');
    });
});


Route::fallback(function () {
    return redirect('/');
});
