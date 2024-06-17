<?php

namespace App\Http\Controllers;

use App\Services\SizeServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeConstroller extends Controller
{
    protected $sizeServices;
    public function __construct(SizeServices $sizeServices)
    {
        $this->sizeServices = $sizeServices;
    }

    public function Xem()
    {
        $data = $this->sizeServices->XemSize();
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $data
        ], 200);
    }

    public function Them(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:100',

        ], [
            'ten.required' => 'vui lòng nhập tên',
            'ten.string' => 'Tên size phải là chữ a-z hoặc 0-9',
            'ten.max' => 'nhiều nhất 100 ký tự',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $tenLoai = $this->sizeServices->TimTen($request->ten);

        if ($tenLoai->count() > 0) {
            return response()->json([
                'status' => 'error',
                'errors' => "Size đã tồn tại"
            ], 422);
        };
        $this->sizeServices->ThemSize($request->ten);
        return response([
            'message' => "thành công",
        ]);
    }

    public function Sua(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:100',
        ], [
            'ten.required' => 'vui lòng nhập tên',
            'ten.string' => 'Tên size phải là chữ a-z hoặc 0-9',
            'ten.max' => 'nhiều nhất 100 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tenLoai = $this->sizeServices->TimTen($request->ten);
        if ($tenLoai->count() > 0) {
            return response()->json([
                'status' => 'error',
                'errors' => "Size đã tồn tại"
            ], 422);
        };

        if ($this->sizeServices->SuaSize($request->ten, $id) == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'không tìm thấy Size'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }


    public function Xoa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'id.required' => 'Không tìm thấy id size',
            'id.integer' => 'ID size phải là số 0-9',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        if ($this->sizeServices->XoaSize($request->id) == 0 || $request->id == 1) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'Không tìm thấy size hoặc size không thể xoá'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }
}
