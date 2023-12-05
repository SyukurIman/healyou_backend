<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DonasiController;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\DataDonasiApiController;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class)->name('register');

Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/create_donasi' , [DonasiController::class,'create']);

    // Payment
    Route::post('/payment/data/all', [PaymentController::class, 'get_data_all']);
    Route::post('/payment/create', [PaymentController::class, 'create_payment']);
    Route::post('/payment/status', [PaymentController::class, 'check_status_payment']);
    Route::post('/payment/data/donasi', [PaymentController::class, 'get_data_id_donasi']);
    Route::post('/payment/data', [PaymentController::class, 'get_data']);

});

Route::post('payments/notif', [PaymentCallbackController::class, 'receive']);
Route::get('pilihan/data_donasi', [DataDonasiApiController::class, 'get_data_donasi']);
Route::get('pilihan/detail_data_donasi', [DataDonasiApiController::class, 'get_detail_data_donasi']);



