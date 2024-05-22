<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrangChuController;
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

Route::get('/', [TrangChuController::class, 'Home']);
Route::get('/Menu', [TrangChuController::class, 'Menu']);
Route::post('/Dat-Mon', [TrangChuController::class, 'DatMon']);
Route::get('/Lich-Su-Mon/{thongTin}', [TrangChuController::class, 'LichSuMon']);
Route::post('/Nhap-Ban/{banID}', [TrangChuController::class, 'NhapThongTin']);
