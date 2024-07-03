<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\DatMonController;
use App\Http\Controllers\HoaDonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoaiController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\SizeConstroller;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\YeuCauConTRoller;

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

/**/
Route::post('/Login', [NguoiDungController::class, 'login'])->middleware('api');
Route::post('/Logout', [NguoiDungController::class, 'logout'])->middleware('api');
Route::get('/login', [NguoiDungController::class, 'showLoginForm'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::get('me', [NguoiDungController::class, 'me']);

    Route::prefix('Ban')->group(function () {
        Route::get('/Xem', [BanController::class, 'DanhSachBan']);
        Route::post('/Xoa', [BanController::class, 'Xoa']);
        Route::post('/Them', [BanController::class, 'Them']);
    });
    Route::prefix('Loai')->group(function () {
        Route::post('/Them', [LoaiController::class, 'Them']);
        Route::post('/Xoa', [LoaiController::class, 'Xoa']);
        Route::post('/Sua', [LoaiController::class, 'Sua']);
        Route::get('/Xem/{id}', [LoaiController::class, 'XemTungLoai']);
        Route::get('/Xem', [LoaiController::class, 'Xem']);
    });
    Route::prefix('Size')->group(function () {
        Route::get('/Xem', [SizeConstroller::class, 'Xem']);
        Route::get('/Xem/{id}', [SizeConstroller::class, 'TungSize']);
        Route::post('/Sua', [SizeConstroller::class, 'Sua']);
        Route::post('/Them', [SizeConstroller::class, 'Them']);
        Route::post('/Xoa', [SizeConstroller::class, 'Xoa']);
    });
    Route::prefix('Nguoi-Dung')->group(function () {
        Route::get('/Xem', [NguoiDungController::class, 'XemDanhSachTaiKhoan']);
        Route::post('/Xoa', [NguoiDungController::class, 'XoaTaiKhoan']);
        Route::post('/Them', [NguoiDungController::class, 'TaoTaiKhoan']);
        Route::post('/Doi-Mat-Khau', [NguoiDungController::class, 'DoiMatKhau']);
        Route::post('/Capnhatthongtin', [NguoiDungController::class, 'Capnhatthongtin'])->middleware('api');
    });



    Route::prefix('San-Pham')->group(function () {
        Route::post('/Them', [SanPhamController::class, 'Them']);
        Route::post('/Them-Anh', [SanPhamController::class, 'ThemAnh']);
        Route::get('/Xem', [SanPhamController::class, 'Xem']);
        Route::get('/Xem/{id}', [SanPhamController::class, 'XemLoai']);
        Route::post('/Trang-Thai', [SanPhamController::class, 'CapNhatTrangThai']);
        Route::post('/Xoa', [SanPhamController::class, 'Xoa']);
    });
    Route::prefix('Yeu-Cau')->group(function () {
        Route::get('/Laydanhsachyeucautungban/{id}', [YeuCauConTRoller::class, 'Laydanhsachyeucautungban'])->middleware('api');

    });

});

Route::get('/Menu/{id}', [MenuController::class, 'Menu']);




Route::prefix('Dat-Mon')->group(function () {
    Route::get('/ban/{id}', [DatMonController::class, 'TaoDatMon']);
    Route::post('/Kiem-Tra-Ban', [DatMonController::class, 'KiemTraMaBan']);
    Route::post('/Them-Mon', [MenuController::class, 'DatMon']);
    Route::post('/Them-So-Luong', [MenuController::class, 'ThemSL']);
    Route::post('/Giam-So-Luong', [MenuController::class, 'GiamSL']);
});

Route::prefix('Yeu-Cau')->group(function () {
    Route::get('/Xem/{ban}', [YeuCauConTRoller::class, 'XemDS']);
    Route::get('/Xem-Tat-Ca', [YeuCauConTRoller::class, 'XemYeuCau']);
    Route::post('/Tao', [YeuCauConTRoller::class, 'TaoYeuCau']);
    Route::get('/Xac-Nhan/{id}', [YeuCauConTRoller::class, 'XacNhanYeuCau']);
});

Route::prefix('Hoa-Don')->group(function () {
    Route::get('/Goi-Mon/{ban}', [HoaDonController::class, 'GoiMon']);
    Route::get('/Danh-Sach-Chi-Tiet/{ban}', [HoaDonController::class, 'DanhSachChiTiet']);
});
