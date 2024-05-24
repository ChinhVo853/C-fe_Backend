<?php

namespace App\Http\Controllers;

use App\Services\LoaiServices;
use Illuminate\Http\Request;

class LoaiController extends Controller
{
    protected $loaiServices;
    public function __construct(LoaiServices $loaiServices)
    {
        $this->loaiServices = $loaiServices;
    }

    public function Them(Request $request)
    {
        $this->loaiServices->ThemLoai($request->ten);
        return response([
            'message' => 'thanh cong'
        ]);
    }
}
