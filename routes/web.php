<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\RentalBukuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// --- PUBLIC ROUTE & AUTH ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registering']);
    Route::get('password/reset', [AuthForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/update', [AuthResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        if ($request->user()->role == 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.resend');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // --- SISWA ROUTE---
    Route::middleware('verified')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('welcome');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [UserController::class, 'update'])->name('profile.update');
    });

    // --- ADMIN PUSTAKAWAN ROUTE ---
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class, 'verified'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Manage Buku Routes
        Route::get('buku', [BukuController::class, 'index']);
        Route::get('add-buku', [BukuController::class, 'add']);
        Route::post('add-buku', [BukuController::class, 'store']);
        Route::get('buku-edit/{slug}', [BukuController::class, 'edit']);
        Route::put('buku-edit/{slug}', [BukuController::class, 'update']);
        Route::get('buku-delete/{slug}', [BukuController::class, 'delete']);
        Route::get('buku-destroy/{slug}', [BukuController::class, 'destroy']);
        Route::get('buku-deleted', [BukuController::class, 'deleted']);
        Route::get('buku-restore/{slug}', [BukuController::class, 'restore']);
        Route::get('rent-buku', [RentalBukuController::class, 'index']);
        Route::post('rent-buku', [RentalBukuController::class, 'rent']);
        Route::get('return-buku', [RentalBukuController::class, 'return']);
        Route::post('return-buku', [RentalBukuController::class, 'returning']);

        // Manage Jenis Routes
        Route::get('jenis', [JenisController::class, 'index']);
        Route::get('jenis-add', [JenisController::class, 'add']);
        Route::post('jenis-add', [JenisController::class, 'store']);
        Route::get('jenis-edit/{slug}', [JenisController::class, 'edit']);
        Route::put('jenis-edit/{slug}', [JenisController::class, 'update']);
        Route::get('jenis-delete/{slug}', [JenisController::class, 'delete']);
        Route::get('jenis-destroy/{slug}', [JenisController::class, 'destroy']);
        Route::get('jenis-deleted', [JenisController::class, 'deleted']);
        Route::get('jenis-restore/{slug}', [JenisController::class, 'restore']);
    
        // Manage Siswa Routes
        Route::get('siswa', [UserController::class, 'index']);
        Route::get('siswa-ban/{slug}', [UserController::class, 'ban']);
        Route::get('siswa-delete/{slug}', [UserController::class, 'delete']);
        Route::get('siswa-banned', [UserController::class, 'banned']);
        Route::get('siswa-restore/{slug}', [UserController::class, 'restore']);
    });
});
