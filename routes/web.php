<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Tenant-scoped and auth-protected routes
Route::middleware(['tenant','auth'])->group(function () {
    // Admin-only routes
        Route::resource('donors', DonorController::class)->except(['show']);
        Route::resource('volunteers', VolunteerController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('donations', DonationController::class)->except(['show']);
        Route::resource('expenses', ExpenseController::class)->except(['show']);
        Route::resource('attendance', AttendanceController::class)->except(['show']);

        Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::resource('message_templates', MessageTemplateController::class);

    // Volunteer read-only
    Route::get('/my/attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.my');
    Route::get('/volunteer/projects', [ProjectController::class, 'volunteerIndex'])->name('projects.volunteer-index');
});
