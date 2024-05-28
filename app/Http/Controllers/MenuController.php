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
        $result = $this->MenuServices->XemMenu();
        $groupedResult = [];
        foreach ($result as $item) {
            $key = $item->ten_loai . '_' . $item->ten_mon;
            if (!isset($groupedResult[$key])) {
                $groupedResult[$key] = [
                    'ten_loai' => $item->ten_loai,
                    'ten_mon' => $item->ten_mon,
                    'gia' => [],
                    'sizes' => [],
                ];
            }
            $groupedResult[$key]['gia'][] = $item->gia;
            $groupedResult[$key]['sizes'][] = $item->ten_size;
            // Loại bỏ các giá trị trùng lặp
            $groupedResult[$key]['sizes'] = array_unique($groupedResult[$key]['sizes']);
            $groupedResult[$key]['gia'] = array_unique($groupedResult[$key]['gia']);
        }

        return response()->json([
            'message' => 'thanh công',
            'data' => array_values($groupedResult),
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
