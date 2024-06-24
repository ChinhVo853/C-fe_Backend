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
        $data = [];
        foreach ($result as $item) {
            $loaiKey = $item->ten_loai;
            $monKey = $item->ten_mon;

            if (!isset($data[$loaiKey])) {
                $data[$loaiKey] = [
                    'ten_loai' => $item->ten_loai,
                    'mon' => []
                ];
            }

            if (!isset($data[$loaiKey]['mon'][$monKey])) {
                $data[$loaiKey]['mon'][$monKey] = [
                    'ten_mon' => $item->ten_mon,
                    'gia' => [],
                    'sizes' => [],
                    'anh'  => $item->anh
                ];
            }
            // Thêm thông tin giá và size
            $data[$loaiKey]['mon'][$monKey]['gia'][] = $item->gia;
            $data[$loaiKey]['mon'][$monKey]['sizes'][] = $item->ten_size;

            // Loại bỏ các giá trị trùng lặp
            $data[$loaiKey]['mon'][$monKey]['gia'] = array_unique($data[$loaiKey]['mon'][$monKey]['gia']);
            $data[$loaiKey]['mon'][$monKey]['sizes'] = array_unique($data[$loaiKey]['mon'][$monKey]['sizes']);
        }
        return response()->json([
            'message' => 'thanh công',
            'data' => $data,
        ]);
    }



    public function DatMon(Request $request)
    {
        $monID = $this->MenuServices->TimMon($request->tenMon, $request->tenSize);
        $this->MenuServices->ThemMon($request->datMonID, $request->soLuong, $monID->id);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }
}
