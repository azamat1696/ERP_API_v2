<?php

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

Route::get('/', function () {
    return abort('404');
});
Route::any('/pay-transaction/fail',[\App\Http\Controllers\transactionTestController::class,'fail']);
Route::any('/pay-transaction/success',[\App\Http\Controllers\transactionTestController::class,'success']);

Route::any('/pay-transaction/{id}',[\App\Http\Controllers\transactionTestController::class,'test']);
Route::get('/pay-failed/{orderNo}',[\App\Http\Controllers\transactionTestController::class,'payFailed']);

Route::get('/pay-success/{orderNo}',[\App\Http\Controllers\transactionTestController::class,'paySuccess']);
Route::get('test-et/{carId}',[\App\Http\Controllers\Agreement::class,'invoiceCarDamages']);
