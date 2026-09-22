<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CatController as AdminCatController;
use App\Http\Controllers\Admin\VariantController as AdminVariantController;
use App\Http\Controllers\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kucing', [CatController::class, 'index'])->name('cats.index');
Route::get('/kucing/{id}', [CatController::class, 'show'])->name('cats.show');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{id}', [ReservationController::class, 'show'])->name('reservasi.show');
    Route::get('/riwayat-reservasi', [ReservationController::class, 'history'])->name('reservasi.history');

    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

Route::get('/Lulu', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Cats Management (Data Kucing)
    Route::get('/kucing', [AdminCatController::class, 'index'])->name('kucing.index');
    Route::get('/kucing/create', [AdminCatController::class, 'create'])->name('kucing.create');
    Route::post('/kucing', [AdminCatController::class, 'store'])->name('kucing.store');
    Route::get('/kucing/{id}/edit', [AdminCatController::class, 'edit'])->name('kucing.edit');
    Route::put('/kucing/{id}', [AdminCatController::class, 'update'])->name('kucing.update');
    Route::delete('/kucing/{id}', [AdminCatController::class, 'destroy'])->name('kucing.destroy');

    // Variants Management
    Route::get('/variants', [AdminVariantController::class, 'index'])->name('variants.index');
    Route::post('/variants', [AdminVariantController::class, 'store'])->name('variants.store');
    Route::put('/variants/{id}', [AdminVariantController::class, 'update'])->name('variants.update');
    Route::delete('/variants/{id}', [AdminVariantController::class, 'destroy'])->name('variants.destroy');

    // Sessions Management
    Route::get('/sessions', [AdminSessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions', [AdminSessionController::class, 'store'])->name('sessions.store');
    Route::put('/sessions/{id}', [AdminSessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{id}', [AdminSessionController::class, 'destroy'])->name('sessions.destroy');

    // Reservations & Payments Management
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::delete('/reservations/{id}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/payments', [AdminReservationController::class, 'payments'])->name('payments.index');

    // Feedbacks Moderation
    Route::get('/feedbacks', [AdminFeedbackController::class, 'index'])->name('feedbacks.index');
    Route::patch('/feedbacks/{id}/toggle', [AdminFeedbackController::class, 'toggleStatus'])->name('feedbacks.toggle');
    Route::delete('/feedbacks/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedbacks.destroy');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});