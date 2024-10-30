<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

// test routes
Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'back.pages.admin.auth.login')->name('login');
        Route::view('/forgot-password', 'back.pages.admin.auth.forgot')->name('forgot-password');
        Route::post('/login_handler', [AdminController::class, 'loginHandler'])->name('login_handler');
        Route::post('/send-reset-password-link', [AdminController::class, 'sendResetPasswordLink'])->name('send-reset-password-link');
        Route::get('/password/reset/{token}', [AdminController::class, 'resetPassword'])->name('reset-password');
        Route::post('/reset-password-handler', [AdminController::class, 'resetPasswordHandler'])->name('reset-password-handler');
    });

    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::post('logout_handler', 'logoutHandler')->name('logout_handler');
            Route::get('/dashboard', 'adminDashboard')->name('dashboard');
            Route::get('/home', 'adminHome')->name('home');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('change-profile-picture');
            Route::view('/settings', 'back.pages.admin.settings')->name('settings');
            Route::post('/change-logo', 'changeLogo')->name('change-logo');
            Route::post('/change-favicon', 'changeFavicon')->name('change-favicon');
        });

        Route::prefix('sales')->name('sales.')->group(function () {
            Route::view('/add', 'back.pages.admin.add-sales')->name('add-sales');
            Route::view('/order-summary', 'back.pages.admin.order-summary')->name('order-summary');

            Route::controller(TransactionController::class)->group(function () {
                Route::get('/transactions', 'index')->name('all-transactions');
                Route::get('/transactions/{transaction_code}', 'show')->name('transaction-details');
            });

            Route::controller(RefundController::class)->group(function () {
                Route::get('/refunds', 'index')->name('all-refunds');
                Route::get('/refund/{transaction_code}', 'show')->name('refund');
            });
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::view('/all', 'back.pages.admin.all-products')->name('all-products');
            Route::view('/add', 'back.pages.admin.add-product')->name('add-product');
        });

        Route::prefix('consignment')->name('consignment.')->group(function () {
            Route::view('/all', 'back.pages.admin.all-consign')->name('all-consign');
            Route::view('/add', 'back.pages.admin.add-consign')->name('add-consign');
        });

        Route::prefix('payment')->name('payment.')->group(function () {
            Route::controller(PaymentController::class)->group(function () {
                Route::get('/all', 'index')->name('all-payments');
            });
        });
    });
});

Route::prefix('consignor')->name('consignor.')->group(function () {
    Route::middleware(['guest:user', 'PreventBackHistory'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/login', 'login')->name('login');
            Route::post('/login-handler', 'loginHandler')->name('login-handler');
            Route::get('/register', 'register')->name('register');
            Route::post('/create', 'createConsignor')->name('create');
            Route::get('/account/verify/{token}', 'verifyAccount')->name('verify');
            Route::get('/register-success', 'registerSuccess')->name('register-success');
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::post('/send-password-reset-link', 'sendPasswordResetLink')->name('send-password-reset-link');
            Route::get('/password/reset/{token}', 'showResetForm')->name('reset-password');
        });
    });

    Route::middleware(['auth:user', 'PreventBackHistory'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/home', 'home')->name('home');
            Route::post('/logout', 'logoutHandler')->name('logout-handler');
        });
    });
});
