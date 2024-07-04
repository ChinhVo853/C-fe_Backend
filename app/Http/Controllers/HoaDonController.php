<?php

namespace App\Http\Controllers;

use App\Services\HoaDonServices;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    protected $HoaDonServices;
    public function __construct(HoaDonServices $HoaDonServices)
    {
        $this->HoaDonServices = $HoaDonServices;
    }
    public function GoiMon($ban)
    {
        $trangThaiBan = $this->HoaDonServices->TrangThaiBan($ban);
        if ($trangThaiBan == 3) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'Không thể thêm'
            ], 422);
        }
        $datMonID = $this->HoaDonServices->LayIDDatMon($ban);
        $taoHoaDon = $this->HoaDonServices->TimVaTaoHoaDon($datMonID->id);
        $dsChiTietDatMon = $this->HoaDonServices->LayCTDatMon($datMonID->id);
        $tongTien = $this->HoaDonServices->LayTiongTien($taoHoaDon);
        foreach ($dsChiTietDatMon as $item) {
            $thanhTien = $item->so_luong * $item->gia;
            $tongTien += $thanhTien;
            $this->HoaDonServices->LuuChiTietHoaDon($taoHoaDon, $item->mon_an_id, $item->so_luong, $thanhTien);
        }
        $this->HoaDonServices->capNhatTongTien($taoHoaDon, $tongTien);
        $this->HoaDonServices->XoaChiTietDatMon($datMonID->id);
        return response()->json([
            'message' => 'Thành công',
        ]);
    }


    public function DanhSachChiTiet($ban)
    {
        $datMonID = $this->HoaDonServices->LayIDDatMon($ban);
        $data = $this->HoaDonServices->LayDSCThoaDon($datMonID->id);
        return response()->json([
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    public function DanhSachHoaDon($ban)
    {
        $data = $this->HoaDonServices->LayDSHoaDon($ban);
        return response()->json([
            'message' => 'Thành công',
            'data' => $data
        ]);
    }
}
