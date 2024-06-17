<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoaiController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\SizeConstroller;
use App\Http\Controllers\NguoiDungController;

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

// nguoi dung

Route::post('/Login', [NguoiDungController::class, 'login'])->middleware('api');
Route::get('/me', [NguoiDungController::class, 'me'])->middleware('api');
Route::post('/Logout', [NguoiDungController::class, 'logout'])->middleware('api');


Route::get('/Trang-Chu/{banID}', [TrangChuController::class, 'Home']);
Route::get('/Menu', [MenuController::class, 'Menu']);
Route::post('/Dat-Mon/{banID}', [MenuController::class, 'DatMon']);
Route::get('/Lich-Su-Mon/{thongTin}', [TrangChuController::class, 'LichSuMon']);
Route::post('/Nhap-Ban/{banID}', [TrangChuController::class, 'NhapThongTin']);

Route::prefix('Loai')->group(function () {
    Route::post('/Them', [LoaiController::class, 'Them']);
    Route::post('/Xoa', [LoaiController::class, 'Xoa']);
    Route::post('/Sua/{id}', [LoaiController::class, 'Sua']);
    Route::get('/Xem', [LoaiController::class, 'Xem']);
});

Route::prefix('Size')->group(function () {
    Route::get('/Xem', [SizeConstroller::class, 'Xem']);
    Route::post('/Sua/{id}', [SizeConstroller::class, 'Sua']);
    Route::post('/Them', [SizeConstroller::class, 'Them']);
    Route::post('/Xoa', [SizeConstroller::class, 'Xoa']);
});

Route::prefix('San-Pham')->group(function () {
    Route::post('/Them', [SanPhamController::class, 'Them']);
    Route::post('/Them-Anh', [SanPhamController::class, 'ThemAnh']);
    Route::get('/Xem', [SanPhamController::class, 'Xem']);
});


Route::prefix('Nguoi-Dung')->group(function () {
    Route::get('/Xem', [NguoiDungController::class, 'XemDanhSachTaiKhoan']);
    Route::post('/Xoa', [NguoiDungController::class, 'XoaTaiKhoan']);
    Route::post('/Them', [NguoiDungController::class, 'TaoTaiKhoan']);
    Route::post('/Doi-Mat-Khau', [NguoiDungController::class, 'DoiMatKhau']);
});
