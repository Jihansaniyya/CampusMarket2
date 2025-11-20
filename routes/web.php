<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// =============================
// HOMEPAGE (Public)
// =============================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =============================
// AUTH (Guest Only)
// =============================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout (Auth Only)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// =============================
// EMAIL VERIFICATION
// =============================
Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();

        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Email berhasil diverifikasi!');
        } elseif ($user->role === 'seller') {
            return redirect()->route('waiting.approval')->with('success', 'Email berhasil diverifikasi! Menunggu persetujuan admin.');
        }

        return redirect()->route('buyer.dashboard')->with('success', 'Email berhasil diverifikasi!');
    })->middleware(['signed'])->name('verification.verify');

    // Waiting approval page
    Route::get('/waiting-approval', function () {
        return view('auth.waiting-approval');
    })->name('waiting.approval');

    // Resend verification link
    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// =============================
// LEGAL PAGES
// =============================
Route::get('/terms-seller', fn () => view('auth.termsseller'))->name('terms.seller');
Route::get('/privacy-policy', fn () => view('auth.privacypolicy'))->name('privacy.policy');

// =============================
// ADMIN ROUTES
// =============================
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');

    // Seller Approval
    Route::prefix('sellers/approval')->name('sellers.approval.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\Admin\SellerApprovalController::class, 'reject'])->name('reject');
    });
});

// =============================
// SELLER ROUTES
// =============================
Route::prefix('seller')->middleware(['auth', 'verified', 'role:seller'])->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->approval_status !== 'approved') {
            return redirect()->route('waiting.approval');
        }

        return view('seller.dashboard');
    })->name('dashboard');
});

// =============================
// BUYER ROUTES
// =============================
Route::prefix('buyer')->middleware(['auth', 'verified', 'role:buyer'])->name('buyer.')->group(function () {
    Route::get('/dashboard', fn () => view('buyer.dashboard'))->name('dashboard');
});
