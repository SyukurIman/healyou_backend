<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataDonasiController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\UserManagement;
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

Route::get('/admin/home', [AdminController::class, 'home_admin'])->middleware('is_admin')->name('home_admin');


//data_donasi
Route::get('/admin/data_donasi', [DataDonasiController::class, 'data_donasi'])->middleware('is_admin')->name('admin.data_donasi');
Route::post('/admin/data_donasi/table', [DataDonasiController::class, 'table'])->middleware('is_admin')->name('admin.data_donasi.table');
Route::get('/admin/data_donasi/create', [DataDonasiController::class, 'create'])->middleware('is_admin')->name('admin.data_donasi.create');
Route::post('/admin/data_donasi/createform', [DataDonasiController::class, 'createform'])->middleware('is_admin')->name('admin.data_donasi.createform');
Route::get('/admin/data_donasi/update/{id}', [DataDonasiController::class, 'update'])->middleware('is_admin')->name('admin.data_donasi.update');
Route::post('/admin/data_donasi/updateform', [DataDonasiController::class, 'updateform'])->middleware('is_admin')->name('admin.data_donasi.updateform');
Route::post('/admin/data_donasi/deleteform', [DataDonasiController::class, 'deleteform'])->middleware('is_admin')->name('admin.data_donasi.deleteform');

Route::middleware('is_admin')->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home_admin'])->name('home_admin');
    Route::get('/admin/payment/history', [AdminPaymentController::class, 'index'])->name('payment_history_admin');
    Route::get('/admin/payment/history/edit/{id}', [AdminPaymentController::class, 'from_update_status'])->name('edit_payment_history_admin');
    Route::post('/admin/payment/history/edit/{id}', [AdminPaymentController::class, 'save_update_status'])->name('edit_payment_history_admin');

    Route::post('/admin/payment/history/get_all_data', [AdminPaymentController::class, 'get_all_data'])->name('all_history_data_admin');

    Route::get('/admin/user_management', [UserManagement::class, 'index'])->name('user_management_admin');
    Route::post('/admin/user_management/get_all_data', [UserManagement::class, 'get_all_data'])->name('all_user_data_admin');
    Route::get('/admin/user_management/create', [UserManagement::class, 'from_create_user'])->name('user_management_create_admin');
    Route::post('/admin/user_management/create', [UserManagement::class, 'save_create_user'])->name('user_management_create_admin');
    Route::get('/admin/user_management/edit/{id}', [UserManagement::class, 'from_update_user'])->name('user_management_update_admin');
    Route::post('/admin/user_management/edit/{id}', [UserManagement::class, 'save_update_user'])->name('user_management_update_admin');
    Route::post('/admin/user_management/delete/', [UserManagement::class, 'delete_user'])->name('admin.user_management.delete');
});
