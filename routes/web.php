<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GraduationPeriodController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [GraduationController::class, 'index'])->name('home');
Route::post('/check', [GraduationController::class, 'check'])->name('graduation.check');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
Route::get('/announcements/{announcement}',[AnnouncementController::class,'show'])->name('announcements.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('students/template', [StudentController::class, 'template'])->name('students.template');
    Route::resource('students', StudentController::class);


    // Classes Management
    Route::resource('school-classes', SchoolClassController::class);

    // Announcements Management
    Route::post('announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('announcements.publish');
    Route::resource('announcements', AnnouncementController::class);

    // Grades Management
    Route::post('grades/import', [GradeController::class, 'import'])->name('grades.import');
    Route::get('grades/export', [GradeController::class, 'export'])->name('grades.export');
    Route::get('grades/template', [GradeController::class, 'template'])->name('grades.template');
    Route::resource('grades', GradeController::class);


    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/certificate-preview', [SettingController::class, 'previewCertificate'])->name('settings.certificate-preview');

    // Users Management
    Route::resource('users', UserController::class);

    // Graduation Periods
    Route::resource('graduation-periods', GraduationPeriodController::class);


    // Certificate Regeneration
    Route::get('regenerate-certificates', [SettingController::class, 'regenerateCertificates'])->name('settings.regenerate-certificates');

});

// Override the default Breeze dashboard redirect
Route::redirect('/dashboard', '/admin')->name('dashboard');

require __DIR__.'/auth.php';
