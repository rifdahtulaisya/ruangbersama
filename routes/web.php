<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\UserBookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // User
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Booking
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/history', [UserBookingController::class, 'history'])->name('bookings.history');
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookingsdetail/{id}', [UserBookingController::class, 'show'])->name('bookingsdetail');
    Route::post('/bookings/{id}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('rooms', RoomController::class);

        // Bookings
        Route::resource('bookings', BookingController::class);
        // TAMBAHAN INI
    Route::post('bookings/{id}/approve', [BookingController::class, 'approve'])
        ->name('bookings.approve');

    Route::post('bookings/{id}/borrow', [BookingController::class, 'borrow'])
        ->name('bookings.borrow');

    Route::post('bookings/{id}/return', [BookingController::class, 'returnItem'])
        ->name('bookings.return');

        // Profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.change-password');
    });
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

require __DIR__ . '/auth.php';
