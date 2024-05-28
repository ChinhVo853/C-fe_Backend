<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrangchuServices;

class TrangChuController extends Controller
{

    protected $trangChuServices;

    public function __construct(TrangchuServices $trangChuServices)
    {
        $this->trangChuServices = $trangChuServices;
    }

    public function NhapThongTin($banID, Request $request)
    {
        $this->trangChuServices->NhapThongTinBan($banID, $request->thongTin);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }

    public function Home($banID)
    {
        $thong_tin = $this->trangChuServices->layThongTinBan($banID);
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $thong_tin
        ]);
    }

    public function LichSuMon($thongTin)
    {
        $dsLichSu = $this->trangChuServices->XemLichSuMon($thongTin);
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $dsLichSu
        ]);
    }

    public function ChiTietLichSuMon($banID)
    {
        $dsChiTietLichSu = $this->trangChuServices->XemChiTietLichSuMon($banID);
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $dsChiTietLichSu
        ]);
    }

    public function GoiNhanVien($banID)
    {
        $this->trangChuServices->GoiNhanVienBan($banID);
        return response()->json([
            'message' => 'thanh cong'
        ]);
    }
}
