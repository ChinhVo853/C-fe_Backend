<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoaiController;
use App\Http\Controllers\NguyenLieuController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\SizeConstroller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Trang-Chu/{banID}', [TrangChuController::class, 'Home']);
Route::get('/Menu', [MenuController::class, 'Menu']);
Route::post('/Dat-Mon/{banID}', [MenuController::class, 'DatMon']);
Route::get('/Lich-Su-Mon/{thongTin}', [TrangChuController::class, 'LichSuMon']);
Route::post('/Nhap-Ban/{banID}', [TrangChuController::class, 'NhapThongTin']);

Route::prefix('loai')->group(function () {
    Route::post('/Them', [LoaiController::class, 'Them']);
});

Route::prefix('Nguyen-Lieu')->group(function () {
    Route::post('/Them', [NguyenLieuController::class, 'Them']);
});


Route::prefix('Size')->group(function () {
    Route::post('/Them', [SizeConstroller::class, 'Them']);
});

Route::prefix('San-Pham')->group(function () {
    Route::post('/Them', [SanPhamController::class, 'Them']);
    Route::post('/Them-Anh', [SanPhamController::class, 'ThemAnh']);
    Route::get('/Xem', [SanPhamController::class, 'Xem']);
});
