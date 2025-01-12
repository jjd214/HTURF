<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\PaymentController as adminPaymentController;
use App\Http\Controllers\admin\RefundController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\ConsignmentController as adminConsignmentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\ConsignmentController as userConsignmentController;
use App\Http\Controllers\user\PaymentController as userPaymentController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'homePage')->name('home-page');
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin', 'PreventBackHistory', 'RestrictMultipleLogins'])->group(function () {
        Route::view('/login', 'back.pages.admin.auth.login')->name('login');
        Route::view('/forgot-password', 'back.pages.admin.auth.forgot')->name('forgot-password');
        Route::post('/login_handler', [AdminController::class, 'loginHandler'])->name('login_handler');
        Route::post('/send-reset-password-link', [AdminController::class, 'sendResetPasswordLink'])->name('send-reset-password-link');
        Route::get('/password/reset/{token}', [AdminController::class, 'resetPassword'])->name('reset-password');
        Route::post('/reset-password-handler', [AdminController::class, 'resetPasswordHandler'])->name('reset-password-handler');
    });

    Route::middleware(['auth:admin', 'PreventBackHistory', 'RestrictMultipleLogins'])->group(function () {

        Route::view('/logs', 'back.pages.admin.logs')->name('logs');

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
            Route::controller(adminConsignmentController::class)->group(function () {
                Route::get('/all', 'index')->name('all-consign');
                Route::get('/add', 'createConsignment')->name('add-consign');
                Route::get('/all-requests', 'consignmentRequest')->name('all-request');
                Route::get('/details/{id}', 'showConsignmentDetails')->name('details');
                Route::post('/accept-consignment-request/{id}', 'acceptConsignmentRequest')->name('accept-consignment-request');
                Route::post('/reject-consignment-request/{id}', 'rejectConsignmentRequest')->name('reject-consignment-request');
            });
        });

        Route::prefix('payment')->name('payment.')->group(function () {
            Route::controller(adminPaymentController::class)->group(function () {
                Route::get('/all', 'index')->name('all-payments');
                Route::get('/details/{payment_code}', 'showPaymentDetails')->name('details');
                Route::post('/send-payment-details', 'sendPaymentDetails')->name('send-payment-details');
                Route::post('/complete-payment-handler', 'completePaymentHandler')->name('complete-payment-handler');
            });
        });

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::view('/all', 'back.pages.admin.chat')->name('all-chats');
        });
    });
});

Route::prefix('consignor')->name('consignor.')->group(function () {
    Route::middleware(['guest:user', 'PreventBackHistory', 'RestrictMultipleLogins'])->group(function () {
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
            Route::post('/reset-password-handler', 'resetPasswordHandler')->name('reset-password-handler');
        });
    });

    Route::middleware(['auth:user', 'PreventBackHistory', 'RestrictMultipleLogins'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/home', 'home')->name('home');
            Route::post('/logout', 'logoutHandler')->name('logout-handler');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('change-profile-picture');
        });

        Route::prefix('consignment')->name('consignment.')->group(function () {
            Route::controller(userConsignmentController::class)->group(function () {
                Route::get('/add', 'createConsignment')->name('add-consignment');
                Route::get('/all', 'index')->name('all-consignments');
                Route::get('/{id}', 'showConsignmentStatusDetails')->name('show-consignment-status-details');
                Route::get('/{id}/view', 'showConsignmentDetails')->name('show-consignment_details');
                Route::post('/{id}/destroy', 'destroyConsignmentRequest')->name('destroy-consignment-request');
            });
        });

        Route::prefix('payment')->name('payment.')->group(function () {
            Route::controller(userPaymentController::class)->group(function () {
                Route::get('/all', 'index')->name('all-payments');
                Route::get('/details/{payment_code}', 'showPaymentDetails')->name('details');
            });
        });

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::view('/all', 'back.pages.user.chat')->name('all-chats');
        });
    });
});
