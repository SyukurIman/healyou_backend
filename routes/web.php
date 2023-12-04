<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/payment/{id}', [PaymentController::class, 'show_example_test']);

// Auth Admin
Route::get('/admin/login', [AdminController::class, 'admin_login_view'])->middleware('guest')->name('login_admin');
Route::post('/admin/login', [AdminController::class, 'store'])->middleware('guest');
Route::get('/admin/logout', [AdminController::class, 'destroy'])->middleware('is_admin')->name('logout_admin');

Route::middleware('is_admin')->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home_admin'])->name('home_admin');
    Route::get('/admin/payment/history', [AdminPaymentController::class, 'index'])->name('payment_history_admin');
    Route::get('/admin/payment/history/edit/{id}', [AdminPaymentController::class, 'from_update_status'])->name('edit_payment_history_admin');
    Route::post('/admin/payment/history/edit/{id}', [AdminPaymentController::class, 'save_update_status'])->name('edit_payment_history_admin');

    Route::post('/admin/payment/history/get_all_data', [AdminPaymentController::class, 'get_all_data'])->name('all_history_data_admin');
});
