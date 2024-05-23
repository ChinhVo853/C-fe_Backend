<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuServices;


class MenuController extends Controller
{
    protected $MenuServices;
    public function __construct(MenuServices $MenuServices)
    {
        $this->MenuServices = $MenuServices;
    }
    public function Menu()
    {
        $result =  $this->MenuServices->XemMenu();
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

    public function DatMon(Request $request, $banID)
    {
        $lichSuBanID = $this->MenuServices->TaoHoaDon($request);
        $tongTien = $this->MenuServices->LuuChiTietBan($request, $lichSuBanID);
        $this->MenuServices->CapNhatTongTienLS($tongTien, $lichSuBanID);
        $this->MenuServices->CapNhatBan($banID, $lichSuBanID);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }
}
