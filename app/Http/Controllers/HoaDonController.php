<?php

namespace App\Http\Controllers;

use App\Services\HoaDonServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $dsChiTietDatMon = $this->HoaDonServices->LayCTDatMon($datMonID->id);
        if ($dsChiTietDatMon->count() == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'vui lòng thêm món'
            ], 422);
        }
        $taoHoaDon = $this->HoaDonServices->TimVaTaoHoaDon($datMonID->id, $ban);
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
        if (!isset($datMonID)) {
            return response()->json([
                'message' => 'Thành công',
                'data' => []
            ]);
        }
        $hoaDon = $this->HoaDonServices->TimHoaDon($ban, $datMonID->id);

        if (!isset($hoaDon)) {
            return response()->json([
                'message' => 'Thành công',
                'data' => []
            ]);
        }
        $data = $this->HoaDonServices->LayDSCThoaDon($hoaDon->id);
        return response()->json([
            'message' => 'Thành công',
            'data' => $data
        ]);
    }

    public function ChiTietHoaDonTheoMa($id)
    {
        $data = $this->HoaDonServices->LayDSCThoaDon($id);
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


    public function XacNhanChiTiet($id)
    {
        $this->HoaDonServices->ChiTietXacNhan($id);
        return response()->json([
            'message' => 'Thành công',
        ]);
    }

    public function TimNgayHoaDon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ngayDB' => 'required',
            'ngayKT' => 'required'
        ], [
            'ngayDB.required' => 'Vui lòng chọn ngày bắt đầu',
            'ngayKT.required' => 'Vui lòng chọn ngày kết thúc',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $this->HoaDonServices->TimNgayHD($request->ngayDB, $request->ngayKT, $request->ban);
        return response()->json([
            'message' => 'Thành công',
            'data' => $data
        ]);
    }
}
