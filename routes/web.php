<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserLoanController;
use App\Http\Controllers\UserDashboardController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Loan
    Route::get('/loans', [UserLoanController::class, 'index'])->name('loans');
    Route::post('/loans', [UserLoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/history', [UserLoanController::class, 'history'])->name('loans.history');
    Route::get('/loans/{id}', [UserLoanController::class, 'show'])->name('loans.show');
    Route::delete('/loans/{id}/cancel', [UserLoanController::class, 'destroy'])->name('loans.cancel');

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('books', BookController::class);

        // Loan
        Route::resource('loans', LoanController::class);
        Route::post('loans/{id}/approve', [LoanController::class, 'approve'])
            ->name('loans.approve');
        Route::post('loans/{id}/return', [LoanController::class, 'returnItem'])
            ->name('loans.return');

        // Members
        Route::get('members/export-pdf', [MemberController::class, 'exportPDF'])->name('members.export-pdf');
        Route::get('members/export-csv', [MemberController::class, 'export'])->name('members.export-csv');
        Route::resource('members', MemberController::class);

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
