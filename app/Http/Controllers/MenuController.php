<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuServices;

use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    protected $MenuServices;
    public function __construct(MenuServices $MenuServices)
    {
        $this->MenuServices = $MenuServices;
    }
    public function Menu($id)
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
                    'anh'  => $item->anh,
                    'trang_thai' => $item->trang_thai
                ];
            }
            // Thêm thông tin giá và size
            $data[$loaiKey]['mon'][$monKey]['gia'][] = $item->gia;
            $data[$loaiKey]['mon'][$monKey]['sizes'][] = $item->ten_size;

            // Loại bỏ các giá trị trùng lặp
            $data[$loaiKey]['mon'][$monKey]['gia'] = array_unique($data[$loaiKey]['mon'][$monKey]['gia']);
            $data[$loaiKey]['mon'][$monKey]['sizes'] = array_unique($data[$loaiKey]['mon'][$monKey]['sizes']);
        }


        $datMon = $this->MenuServices->TimDatMon($id);
        $chiTietDatMon = $this->MenuServices->DSChiTietDatMon($datMon->id);

        return response()->json([
            'message' => 'thanh công',
            'data' => $data,
            'dat_mon' => $chiTietDatMon
        ]);
    }



    public function DatMon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenMon' => 'required|string|max:100',
            'tenSize' => 'required|string|max:100',
            'id' => 'required|integer|max:100',
            'soLuong' => 'required|integer|max:100'
        ], [
            'tenMon.required' => 'vui lòng nhập tên món',
            'tenMon.string' => 'Tên món phải là chữ a-z hoặc 0-9',
            'tenMon.max' => 'nhiều nhất 100 ký tự',
            'tenSize.required' => 'vui lòng nhập tên size',
            'tenSize.string' => 'tên size loại phải là chữ a-z hoặc 0-9',
            'tenSize.max' => 'nhiều nhất 100 ký tự',
            'id.required' => 'vui lòng nhập id',
            'id.integer' => 'id phải là số 0-9',
            'id.max' => 'nhiều nhất 100 ký tự',
            'soLuong.required' => 'vui lòng nhập số lượng',
            'soLuong.integer' => 'Số lượng phải là số 0-9',
            'soLuong.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $monID = $this->MenuServices->TimMon($request->tenMon, $request->tenSize);
        $datMon = $this->MenuServices->TimDatMon($request->id);
        $chiTietDatMon = $this->MenuServices->TimCTDM($monID->id, $datMon->id);
        if (!empty($chiTietDatMon)) {
            $this->MenuServices->ThemSoLuong($monID->id, $datMon->id);
            return response()->json([
                'message' => 'thanh cong',
            ]);
        }
        $this->MenuServices->ThemMon($datMon->id, $request->soLuong, $monID->id);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }

    public function ThemSL(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenMon' => 'required|string|max:100',
            'tenSize' => 'required|string|max:100',
            'id' => 'required|integer|max:100',
        ], [
            'tenMon.required' => 'vui lòng nhập tên món',
            'tenMon.string' => 'Tên món phải là chữ a-z hoặc 0-9',
            'tenMon.max' => 'nhiều nhất 100 ký tự',
            'tenSize.required' => 'vui lòng nhập tên size',
            'tenSize.string' => 'tên size loại phải là chữ a-z hoặc 0-9',
            'tenSize.max' => 'nhiều nhất 100 ký tự',
            'id.required' => 'vui lòng nhập id',
            'id.integer' => 'id phải là số 0-9',
            'id.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $monID = $this->MenuServices->TimMon($request->tenMon, $request->tenSize);
        $datMon = $this->MenuServices->TimDatMon($request->id);
        $this->MenuServices->ThemSoLuong($monID->id, $datMon->id);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }

    public function GiamSL(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenMon' => 'required|string|max:100',
            'tenSize' => 'required|string|max:100',
            'id' => 'required|integer|max:100',
        ], [
            'tenMon.required' => 'vui lòng nhập tên món',
            'tenMon.string' => 'Tên món phải là chữ a-z hoặc 0-9',
            'tenMon.max' => 'nhiều nhất 100 ký tự',
            'tenSize.required' => 'vui lòng nhập tên size',
            'tenSize.string' => 'tên size loại phải là chữ a-z hoặc 0-9',
            'tenSize.max' => 'nhiều nhất 100 ký tự',
            'id.required' => 'vui lòng nhập id',
            'id.integer' => 'id phải là số 0-9',
            'id.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $monID = $this->MenuServices->TimMon($request->tenMon, $request->tenSize);
        $datMon = $this->MenuServices->TimDatMon($request->id);
        $this->MenuServices->GiamSoLuong($monID->id, $datMon->id);
        $soLuong = $this->MenuServices->KiemTraSL($monID->id, $datMon->id);
        if ($soLuong->so_luong == 0) {
            $this->MenuServices->Xoa($monID->id, $datMon->id);
        }
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }
}
