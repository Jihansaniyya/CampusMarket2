<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

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
            // Redirect seller to waiting approval page after email verification
            return redirect()->route('waiting.approval')->with('success', 'Email berhasil diverifikasi! Menunggu persetujuan admin.');
        } else {
            return redirect()->route('buyer.dashboard')->with('success', 'Email berhasil diverifikasi!');
        }
    })->middleware(['signed'])->name('verification.verify');
    
    // Waiting Approval Page (for sellers)
    Route::get('/waiting-approval', function () {
        return view('auth.waiting-approval');
    })->name('waiting.approval');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang ke email Anda!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Terms and Conditions Routes
Route::get('/terms-seller', function () {
    return view('auth.termsseller'); // Sesuaikan dengan path file Blade yang kamu buat
})->name('terms.seller');

//Privacy Policy Route
Route::get('/privacy-policy', function () {
    return view('auth.privacypolicy'); // Sesuaikan dengan nama file Blade yang kamu buat
})->name('privacy.policy');


// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Seller Approval Routes
    Route::prefix('sellers/approval')->name('sellers.approval.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'reject'])->name('reject');
    });
});

// Seller Routes
Route::prefix('seller')->middleware(['auth', 'verified', 'role:seller'])->name('seller.')->group(function () {
    Route::get('/dashboard', function() {
        // Check if seller is approved
        if (Auth::user()->approval_status !== 'approved') {
            return redirect()->route('waiting.approval');
        }
        return view('seller.dashboard');
    })->name('dashboard');
});

// Buyer Routes
Route::prefix('buyer')->middleware(['auth', 'verified', 'role:buyer'])->name('buyer.')->group(function () {
    Route::get('/dashboard', function() {
        return view('buyer.dashboard');
    })->name('dashboard');
});