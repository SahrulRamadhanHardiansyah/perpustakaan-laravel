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

    // Dashboard
    Route::get('/', [UserController::class, 'index'])->name('welcome');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // --- SISWA ROUTE---
    Route::middleware([\App\Http\Middleware\SiswaMiddleware::class,'verified'])->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [UserController::class, 'update'])->name('profile.update');

        Route::get('/pinjam-buku', [RentalBukuController::class, 'pinjamBuku'])->name('pinjam.buku');
        Route::post('/pinjam-buku', [RentalBukuController::class, 'prosesPinjamBuku'])->name('proses.pinjam.buku');
    });

    // --- GURU ROUTE ---
    Route::middleware([\App\Http\Middleware\GuruMiddleware::class, 'verified'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('siswa', [AdminController::class, 'showSiswa'])->name('siswa.index');
        Route::get('rent-buku', [RentalBukuController::class, 'index'])->name('rent.buku');
        Route::post('rent-buku', [RentalBukuController::class, 'rent'])->name('rent.buku.store');
        Route::get('return-buku', [RentalBukuController::class, 'return'])->name('return.buku');
        Route::post('return-buku', [RentalBukuController::class, 'returning'])->name('proses.return.buku');
        Route::get('peminjaman', [RentalBukuController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile.index');
    });

    // --- ADMIN PUSTAKAWAN ROUTE ---
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class, 'verified'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile.index');
        Route::get('/profile/edit', [AdminController::class, 'profileEdit'])->name('profile.edit');
        Route::patch('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');

        // Manage Buku Routes
        Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('add-buku', [BukuController::class, 'add'])->name('buku.add');
        Route::post('add-buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('buku-edit/{slug}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('buku-edit/{slug}', [BukuController::class, 'update'])->name('buku.update');
        Route::get('buku-delete/{slug}', [BukuController::class, 'delete'])->name('buku.delete');
        Route::get('buku-destroy/{slug}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('buku-deleted', [BukuController::class, 'deleted'])->name('buku.deleted');
        Route::get('buku-restore/{slug}', [BukuController::class, 'restore'])->name('buku.restore');

        // Peminjaman dan Pengembalian
        Route::get('rent-buku', [RentalBukuController::class, 'index'])->name('rent.buku');
        Route::post('rent-buku', [RentalBukuController::class, 'rent'])->name('rent.buku.store');
        Route::get('return-buku', [RentalBukuController::class, 'return'])->name('return.buku');
        Route::post('return-buku', [RentalBukuController::class, 'returning'])->name('proses.return.buku');
        Route::get('peminjaman', [RentalBukuController::class, 'peminjaman'])->name('peminjaman');

        // Manage Jenis Routes
        Route::get('jenis', [JenisController::class, 'index'])->name('jenis.index');
        Route::get('jenis-add', [JenisController::class, 'add'])->name('jenis.add');
        Route::post('jenis-add', [JenisController::class, 'store'])->name('jenis.store');
        Route::get('jenis-edit/{slug}', [JenisController::class, 'edit'])->name('jenis.edit');
        Route::put('jenis-edit/{slug}', [JenisController::class, 'update'])->name('jenis.update');
        Route::get('jenis-delete/{slug}', [JenisController::class, 'delete'])->name('jenis.delete');
        Route::get('jenis-destroy/{slug}', [JenisController::class, 'destroy'])->name('jenis.destroy');
        Route::get('jenis-deleted', [JenisController::class, 'deleted'])->name('jenis.deleted');
        Route::get('jenis-restore/{slug}', [JenisController::class, 'restore'])->name('jenis.restore');

        // Manage Siswa Routes
        Route::get('siswa', [AdminController::class, 'showSiswa'])->name('siswa.index');
        Route::get('siswa-detail/{slug}', [AdminController::class, 'detail'])->name('siswa.detail');
        Route::get('siswa-edit/{slug}', [AdminController::class, 'edit'])->name('siswa.edit');
        Route::put('siswa-edit/{slug}', [AdminController::class, 'update'])->name('siswa.update');
        Route::get('siswa-ban/{slug}', [AdminController::class, 'ban'])->name('siswa.ban');
        Route::delete('siswa-destroy/{slug}', [AdminController::class, 'destroy'])->name('siswa.destroy');
        Route::get('siswa-banned', [AdminController::class, 'banned'])->name('siswa.banned');
        Route::post('siswa-restore/{slug}', [AdminController::class, 'restore'])->name('siswa.restore');
    });
});
