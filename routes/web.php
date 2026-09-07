<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Books management
        Route::resource('books', BookController::class);

        // Members management
        Route::resource('members', MemberController::class);

        // Transactions management
        Route::resource('transactions', TransactionController::class);
        Route::post('transactions/{transaction}/return', [TransactionController::class, 'return'])->name('transactions.return');
    });

    // User routes
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
        Route::get('/books', [BookController::class, 'catalog'])->name('books.catalog');
        Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
        Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
        Route::get('/my-loans', [TransactionController::class, 'myLoans'])->name('loans');
        Route::post('/transactions/{transaction}/return', [TransactionController::class, 'userReturn'])->name('transactions.return');
    });
});
