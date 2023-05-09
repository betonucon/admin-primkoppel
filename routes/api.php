<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\OrderController;
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
Route::post('login', [AuthController::class, 'login']);
Route::post('customer/login', [AuthController::class, 'login_customer']);
Route::post('cek-login', [AuthController::class, 'cek_login']);
Route::get('pinjaman/reset_pinjaman', [PinjamanController::class, 'reset_pinjaman']);
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->group( function () {
    Route::get('barang', [BarangController::class, 'barang']);
    Route::group(['prefix' => 'master'],function(){
        Route::get('nilai', [MasterController::class, 'nilai']);
        Route::get('akses_bayar', [MasterController::class, 'akses_bayar']);
        Route::get('tujuan', [MasterController::class, 'tujuan']);
    });
    Route::group(['prefix' => 'pinjaman'],function(){
        Route::post('/', [PinjamanController::class, 'store']);
        
    });
    Route::group(['prefix' => 'order'],function(){
        Route::get('/keranjang', [OrderController::class, 'keranjang']);
        Route::get('/check_keranjang', [OrderController::class, 'check_keranjang']);
        Route::get('/checkall_keranjang', [OrderController::class, 'checkall_keranjang']);
        Route::get('/uncheck_keranjang', [OrderController::class, 'uncheck_keranjang']);
        Route::get('/uncheckall_keranjang', [OrderController::class, 'uncheckall_keranjang']);
        Route::get('/delete_keranjang', [OrderController::class, 'delete_keranjang']);
        Route::post('/store', [OrderController::class, 'store']);
        Route::post('/store_keranjang', [OrderController::class, 'store_keranjang']);
    });
});


Route::get('barang_non', [BarangController::class, 'barang_non']);
Route::post('register', [AuthController::class, 'register']);
