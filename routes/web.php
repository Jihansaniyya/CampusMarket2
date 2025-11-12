<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    // Redirect ke login jika belum login, atau ke dashboard jika sudah login
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('welcome.home');
    }
    return redirect()->route('login');
})->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Email berhasil diverifikasi!');
        } elseif ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')->with('success', 'Email berhasil diverifikasi!');
        } else {
            return redirect()->route('buyer.dashboard')->with('success', 'Email berhasil diverifikasi!');
        }
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang ke email Anda!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Seller Routes
Route::prefix('seller')->middleware(['auth', 'verified', 'role:seller'])->name('seller.')->group(function () {
    Route::get('/dashboard', function() {
        return view('seller.dashboard');
    })->name('dashboard');
});

// Buyer Routes
Route::prefix('buyer')->middleware(['auth', 'verified', 'role:buyer'])->name('buyer.')->group(function () {
    Route::get('/dashboard', function() {
        return view('buyer.dashboard');
    })->name('dashboard');
});