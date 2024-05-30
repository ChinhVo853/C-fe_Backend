<?php

namespace App\Http\Controllers;

use App\Services\NguyenLieuServices;
use Illuminate\Http\Request;

class NguyenLieuController extends Controller
{
    protected $nguyenLieuServices;
    public function __construct(nguyenLieuServices $nguyenLieuServices)
    {
        $this->nguyenLieuServices = $nguyenLieuServices;
    }



    public function Them(Request $request)
    {
        $this->nguyenLieuServices->ThemNguyenLieu($request->ten, $request->donViID, $request->soLuong);
        return response([
            'message' => 'thanh cong'
        ]);
    }
}
