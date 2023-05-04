<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\SimpanansukarelaController;
use App\Http\Controllers\SimpananpokokController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\RiwayatpinjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksipinjamanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\OrderstokController;
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
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('register',[AuthController::class, 'register']);
Route::get('buatanggota',[MasterController::class, 'buatanggota']);
Route::get('get-karyawan',[MasterController::class, 'map']);
Route::post('prosesregister',[AuthController::class, 'prosesregister']);
Route::post('proseslogin',[AuthController::class, 'proseslogin']);
Route::get('login',[AuthController::class, 'login'])->name('login');
Route::post('simpan',[AuthController::class, 'simpan']);
// Route::get('/', function () {
//     return view('welcome');
// })->name('/');
// Route::get('/home', function () {
//     return view('welcome');
// })->name('/home');

Auth::routes();
Route::get('ubah_rupiah',[MasterController::class, 'ubah_rupiah']);

Route::group(['prefix' => 'barang','middleware'    => 'auth'],function(){
    Route::get('/',[BarangController::class, 'index']);
    Route::get('/tambah',[BarangController::class, 'tambah']);
    Route::get('/cari_qr',[BarangController::class, 'cari_qr']);
    Route::get('/cari_barang',[BarangController::class, 'cari_barang']);
    Route::get('/get_data',[BarangController::class, 'get_data']);
    Route::get('/get_data_barang',[BarangController::class, 'get_data_barang']);
    Route::get('/view_file',[BarangController::class, 'view_file']);
    Route::get('/cari_anggota',[BarangController::class, 'cari_anggota']);
    Route::post('/',[BarangController::class, 'save_data']);
    Route::get('/delete',[BarangController::class, 'hapus_data']);
});

Route::group(['prefix' => 'orderstok','middleware'    => 'auth'],function(){
    Route::get('/',[OrderstokController::class, 'index']);
    Route::get('/tambah',[OrderstokController::class, 'tambah']);
    Route::get('/total_harga_kasir',[OrderstokController::class, 'total_harga_kasir']);
    Route::get('/bayar',[OrderstokController::class, 'bayar']);
    Route::get('/view',[OrderstokController::class, 'view']);
    Route::get('/cari_qr',[OrderstokController::class, 'cari_qr']);
    Route::get('/get_data',[OrderstokController::class, 'get_data']);
    Route::get('/get_data_stok',[OrderstokController::class, 'get_data_stok']);
    Route::get('/view_file',[OrderstokController::class, 'view_file']);
    Route::get('/cari_anggota',[OrderstokController::class, 'cari_anggota']);
    Route::post('/',[OrderstokController::class, 'save_data']);
    Route::post('/store_barang',[OrderstokController::class, 'save_barang']);
    Route::post('/store_bayar',[OrderstokController::class, 'save_bayar']);
    Route::get('/delete',[OrderstokController::class, 'hapus_data']);
    Route::get('/delete_barang',[OrderstokController::class, 'hapus_barang']);
});

Route::group(['prefix' => 'kasir','middleware'    => 'auth'],function(){
    Route::get('/',[KasirController::class, 'index']);
    Route::get('/tambah',[KasirController::class, 'tambah']);
    Route::get('/total_harga_kasir',[KasirController::class, 'total_harga_kasir']);
    Route::get('/bayar',[KasirController::class, 'bayar']);
    Route::get('/view',[KasirController::class, 'view']);
    Route::get('/cari_qr',[KasirController::class, 'cari_qr']);
    Route::get('/get_data',[KasirController::class, 'get_data']);
    Route::get('/get_data_stok',[KasirController::class, 'get_data_stok']);
    Route::get('/view_file',[KasirController::class, 'view_file']);
    Route::get('/cari_anggota',[KasirController::class, 'cari_anggota']);
    Route::post('/',[KasirController::class, 'save_data']);
    Route::post('/store_barang',[KasirController::class, 'save_barang']);
    Route::post('/store_bayar',[KasirController::class, 'save_bayar']);
    Route::get('/delete',[KasirController::class, 'hapus_data']);
    Route::get('/delete_barang',[KasirController::class, 'hapus_barang']);
});

Route::group(['prefix' => 'anggota','middleware'    => 'auth'],function(){
    Route::get('/',[AnggotaController::class, 'index']);
    Route::get('/tambah',[AnggotaController::class, 'tambah']);
    Route::get('/get_import',[AnggotaController::class, 'get_import']);
    Route::get('/get_user',[AnggotaController::class, 'get_user']);
    Route::get('/cari_qr',[AnggotaController::class, 'cari_qr']);
    Route::get('/get_data',[AnggotaController::class, 'get_data']);
    Route::get('/view_file',[AnggotaController::class, 'view_file']);
    Route::get('/cari_anggota',[AnggotaController::class, 'cari_anggota']);
    Route::post('/',[AnggotaController::class, 'save_data']);
    Route::get('/delete',[AnggotaController::class, 'hapus_data']);
});
Route::group(['prefix' => 'simpanan','middleware'    => 'auth'],function(){
    Route::get('/',[SimpananController::class, 'index']);
    Route::get('/tambah_wajib',[SimpananController::class, 'tambah_wajib']);
    Route::get('/store_wajib',[SimpananController::class, 'store_wajib']);
    Route::post('/store_sukarela',[SimpananController::class, 'store_sukarela']);
    Route::get('/tambah',[SimpananController::class, 'tambah']);
    Route::get('/get_import',[SimpananController::class, 'get_import']);
    Route::get('/get_user',[SimpananController::class, 'get_user']);
    Route::get('/cari_qr',[SimpananController::class, 'cari_qr']);
    Route::get('/get_data',[SimpananController::class, 'get_data']);
    Route::get('/get_data_wajib',[SimpananController::class, 'get_data_wajib']);
    Route::get('/get_data_sukarela',[SimpananController::class, 'get_data_sukarela']);
    Route::get('/view_file',[SimpananController::class, 'view_file']);
    Route::get('/cari_anggota',[SimpananController::class, 'cari_anggota']);
    Route::post('/',[SimpananController::class, 'save_data']);
    Route::post('/store_wajib_all',[SimpananController::class, 'save_wajib_all']);
    Route::get('/hapus_wajib',[SimpananController::class, 'hapus_wajib']);
    Route::get('/delete_sukarela',[SimpananController::class, 'delete_sukarela']);
});

Route::group(['prefix' => 'wajib','middleware'    => 'auth'],function(){
    Route::get('/',[SimpananwajibController::class, 'index']);
    Route::get('/tambah',[SimpananwajibController::class, 'tambah']);
    Route::get('/get_import',[SimpananwajibController::class, 'get_import']);
    Route::get('/get_user',[SimpananwajibController::class, 'get_user']);
    Route::get('/cari_qr',[SimpananwajibController::class, 'cari_qr']);
    Route::get('/get_data',[SimpananwajibController::class, 'get_data']);
    Route::get('/view_file',[SimpananwajibController::class, 'view_file']);
    Route::get('/cari_anggota',[SimpananwajibController::class, 'cari_anggota']);
    Route::post('/',[SimpananwajibController::class, 'save_data']);
    Route::post('/hapus',[SimpananwajibController::class, 'hapus_data']);
});

Route::group(['prefix' => 'sukarela','middleware'    => 'auth'],function(){
    Route::get('/',[SimpanansukarelaController::class, 'index']);
    Route::get('/tambah',[SimpanansukarelaController::class, 'tambah']);
    Route::get('/get_import',[SimpanansukarelaController::class, 'get_import']);
    Route::get('/get_user',[SimpanansukarelaController::class, 'get_user']);
    Route::get('/cari_qr',[SimpanansukarelaController::class, 'cari_qr']);
    Route::get('/get_data',[SimpanansukarelaController::class, 'get_data']);
    Route::get('/view_file',[SimpanansukarelaController::class, 'view_file']);
    Route::get('/cari_anggota',[SimpanansukarelaController::class, 'cari_anggota']);
    Route::post('/',[SimpanansukarelaController::class, 'save_data']);
    Route::post('/hapus',[SimpanansukarelaController::class, 'hapus_data']);
});
Route::group(['prefix' => 'pokok','middleware'    => 'auth'],function(){
    Route::get('/',[SimpananpokokController::class, 'index']);
    Route::get('/tambah',[SimpananpokokController::class, 'tambah']);
    Route::get('/get_import',[SimpananpokokController::class, 'get_import']);
    Route::get('/get_user',[SimpananpokokController::class, 'get_user']);
    Route::get('/cari_qr',[SimpananpokokController::class, 'cari_qr']);
    Route::get('/get_data',[SimpananpokokController::class, 'get_data']);
    Route::get('/view_file',[SimpananpokokController::class, 'view_file']);
    Route::get('/cari_anggota',[SimpananpokokController::class, 'cari_anggota']);
    Route::post('/',[SimpananpokokController::class, 'save_data']);
    Route::post('/hapus',[SimpananpokokController::class, 'hapus_data']);
});
Route::group(['prefix' => 'pinjaman','middleware'    => 'auth'],function(){
    Route::get('/',[PinjamanController::class, 'index']);
    Route::get('/riwayat',[PinjamanController::class, 'index_riwayat']);
    Route::get('/tambah',[PinjamanController::class, 'tambah']);
    Route::get('/bayar',[PinjamanController::class, 'bayar']);
    Route::get('/delete_cicilan',[PinjamanController::class, 'delete_cicilan']);
    Route::get('/get_import',[PinjamanController::class, 'get_import']);
    Route::get('/get_detail_import',[PinjamanController::class, 'get_detail_import']);
    Route::get('/get_user',[PinjamanController::class, 'get_user']);
    Route::get('/cari_qr',[PinjamanController::class, 'cari_qr']);
    Route::get('/get_data',[PinjamanController::class, 'get_data']);
    Route::get('/get_data_riwayat',[PinjamanController::class, 'get_data_riwayat']);
    Route::get('/view_file',[PinjamanController::class, 'view_file']);
    Route::get('/cari_anggota',[PinjamanController::class, 'cari_anggota']);
    Route::post('/',[PinjamanController::class, 'save_data']);
    Route::post('/store_bayar',[PinjamanController::class, 'save_bayar']);
    Route::post('/hapus',[PinjamanController::class, 'hapus_data']);
});
Route::group(['prefix' => 'Pinjaman','middleware'    => 'auth'],function(){
    Route::get('/',[PinjamanController::class, 'index']);
    Route::get('/tambah',[PinjamanController::class, 'tambah']);
    Route::get('/get_import',[PinjamanController::class, 'get_import']);
    Route::get('/get_detail_import',[PinjamanController::class, 'get_detail_import']);
    Route::get('/get_user',[PinjamanController::class, 'get_user']);
    Route::get('/cari_qr',[PinjamanController::class, 'cari_qr']);
    Route::get('/get_data',[PinjamanController::class, 'get_data']);
    Route::get('/view_file',[PinjamanController::class, 'view_file']);
    Route::get('/cari_anggota',[PinjamanController::class, 'cari_anggota']);
    Route::post('/',[PinjamanController::class, 'save_data']);
    Route::post('/hapus',[PinjamanController::class, 'hapus_data']);
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Gaji',[GajiController::class, 'index']);
    Route::get('Gaji/cetak',[GajiController::class, 'cetak']);
    Route::post('Gaji/import_data',[GajiController::class, 'import_data']);
    
});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('home',[HomeController::class, 'index']);
    Route::get('/',[HomeController::class, 'index']);
});


