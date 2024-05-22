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


    public function Home()
    {
        $thong_tin = $this->trangChuServices->layThongTinBan(1);
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $thong_tin
        ]);
    }

    public function Menu()
    {
        $result =  $this->trangChuServices->XemMenu();
        $groupedResult = collect($result)->reduce(function ($carry, $item) {

            $tenLoai = $item->ten_loai;
            $tenMon = $item->ten_mon;

            if (!isset($carry[$tenLoai])) {
                $carry[$tenLoai] = [];
            }
            if (!isset($carry[$tenMon])) {
                $carry[$tenLoai][$tenMon][] = [
                    'gia' => $item->gia,
                    'ten_size' => $item->ten_size
                ];
            } else {
                $carry[$tenLoai][$tenMon][] = [
                    'gia' => $item->gia,
                    'ten_size' => $item->ten_size
                ];
            }
            return $carry;
        }, []);

        // Chuyển đổi kết quả thành mảng từ collection
        //$groupedResult = array_values($groupedResult);

        return response()->json([
            'message' => 'thanh cong',
            'data' => $groupedResult
        ]);
    }

    public function DatMon(Request $request)
    {
        $tongTien = 0;
        $lichSuBanID = $this->trangChuServices->LuuLichSuBan($request, $tongTien);
        $tongTien = $this->trangChuServices->LuuChiTietBan($request, $lichSuBanID);
        $this->trangChuServices->CapNhatTongTienLS($tongTien, $lichSuBanID);
        return response()->json([
            'message' => 'thanh cong',
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
