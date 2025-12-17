<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\PurchaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/home', function () {
    return redirect()->route('dashboard');
});
// Guest Routes
Route::group(['middleware' => ['guest']], function () {

    //User Login Authentication Routes
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login-attempt', [LoginController::class, 'login_attempt'])->name('login.attempt');
});

// Authentication Routes
Route::group(['middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Payment Routes
    Route::get('/payment-summary', [PaymentController::class, 'summary'])->name('payment.summary');
    Route::get('payment-terminal', [PaymentController::class, 'index'])->name('payment-terminal');
    Route::post('payment/store', [PaymentController::class, 'storePayment'])->name('payment.store');
    Route::delete('payment/delete/{id}', [PaymentController::class, 'deletePayment'])->name('payment.destroy');

    //Purchase Routes
    Route::get('purchase-terminal', [PurchaseController::class, 'index'])->name('purchase-terminal');
    Route::post('purchase/store', [PurchaseController::class, 'storePurchase'])->name('purchase.store');
    Route::delete('purchase/delete/{id}', [PurchaseController::class, 'deletePurchase'])->name('purchase.destroy');
    Route::put('purchase/update/{id}', [PurchaseController::class, 'updatePurchase'])->name('purchase.update');
});

// Frontend Pages Routes
Route::name('frontend.')->group(function () {});


//Artisan Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return "Application cache cleared!";
    })->name('clear.cache');

    Route::get('/clear-config', function () {
        Artisan::call('config:clear');
        return "Configuration cache cleared!";
    })->name('clear.config');

    Route::get('/clear-view', function () {
        Artisan::call('view:clear');
        return "View cache cleared!";
    })->name('clear.view');

    Route::get('/clear-route', function () {
        Artisan::call('route:clear');
        return "Route cache cleared!";
    })->name('clear.route');

    Route::get('/clear-optimize', function () {
        Artisan::call('optimize:clear');
        return "Optimization cache cleared!";
    })->name('clear.optimize');
});
