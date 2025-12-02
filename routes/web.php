<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SellerApprovalController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\ProductCommentController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Seller\RatingController as SellerRatingController;



// =============================
// HOMEPAGE
// =============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ProductSearchController::class, 'search'])->name('product.search');

// =============================
// PRODUCT DETAIL & COMMENTS (For Visitors)
// =============================
Route::get('/product/{slug}', [ProductDetailController::class, 'show'])->name('product.show');
Route::post('/product/comment', [ProductCommentController::class, 'store'])->name('product.comment.store');
Route::get('/product/{productId}/comments', [ProductCommentController::class, 'getProductComments'])->name('product.comments');



// =============================
// AUTH (Guest Only)
// =============================
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

});


// =============================
// LOGOUT
// =============================
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


    Route::get('/waiting-approval', fn () => view('auth.waiting-approval'))
        ->name('waiting.approval');

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
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');

        // Seller Approval
        Route::prefix('sellers/approval')->name('sellers.approval.')->group(function () {
            Route::get('/',       [SellerApprovalController::class, 'index'])->name('index');
            Route::get('/{id}',   [SellerApprovalController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [SellerApprovalController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject',  [SellerApprovalController::class, 'reject'])->name('reject');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/sellers/status',     [ReportController::class, 'sellerStatus'])->name('sellers.status');
            Route::get('/sellers/provinces',  [ReportController::class, 'sellerProvince'])->name('sellers.provinces');
            Route::get('/products/ratings',   [ReportController::class, 'productRatings'])->name('products.ratings');
        });

    });


// =============================
// SELLER ROUTES
// =============================
Route::prefix('seller')
    ->middleware(['auth', 'verified', 'role:seller'])
    ->name('seller.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            $user = auth()->user();
            if ($user->approval_status !== 'approved') {
                return redirect()->route('waiting.approval');
            }
            return app(\App\Http\Controllers\Seller\SellerDashboardController::class)->index();
        })->name('dashboard');


        // =============================
        // PRODUCT ROUTES
        // =============================
        Route::prefix('products')->name('products.')->group(function () {

            // LIST PRODUK
            Route::get('/', [ProductController::class, 'index'])
                ->name('index');  // → seller.product-list.blade.php

            // UPLOAD PRODUK
            Route::get('/create', [ProductController::class, 'create'])
                ->name('create'); // → seller.product.blade.php

            Route::post('/', [ProductController::class, 'store'])->name('store');

            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        });


        // =============================
        // ORDER ROUTES
        // =============================
        Route::prefix('orders')->name('orders.')->group(function () {

            // LIST PESANAN
            Route::get('/', [OrderController::class, 'index'])
                ->name('index'); // → seller.order-list.blade.php

        });


        // =============================
        // RATING ROUTES
        // =============================
        Route::prefix('ratings')->name('ratings.')->group(function () {
            Route::get('/', [SellerRatingController::class, 'index'])->name('index');
        });

    });


// =============================
// BUYER ROUTES
// =============================
Route::prefix('buyer')
    ->middleware(['auth', 'verified', 'role:buyer'])
    ->name('buyer.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('buyer.dashboard'))->name('dashboard');

    });
