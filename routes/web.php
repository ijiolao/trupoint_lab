<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tests', [PublicBookingController::class, 'indexTests']);
Route::get('/book', [PublicBookingController::class, 'showBookingForm']);
Route::post('/book', [PublicBookingController::class, 'storeBooking']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/appointments/today', [AppointmentController::class, 'indexToday'])
            ->name('appointments.today');
    });

require __DIR__.'/auth.php';
