<?php

namespace App\Http\Controllers;

use App\Services\LoaiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoaiController extends Controller
{
    protected $loaiServices;
    public function __construct(LoaiServices $loaiServices)
    {
        $this->loaiServices = $loaiServices;
    }


    public function Xem()
    {
        $data = $this->loaiServices->XemLoai();
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $data
        ], 200);
    }

    public function XemTungLoai($id)
    {
        $data = $this->loaiServices->XemMoiLoai($id);
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $data
        ], 200);
    }

    public function Them(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:255',

        ], [
            'ten.required' => 'vui lòng nhập tên',
            'ten.string' => 'Tên loại phải là chữ a-z hoặc 0-9',
            'ten.max' => 'nhiều nhất 255 ký tự',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $tenLoai = $this->loaiServices->TimTen($request->ten);
        if (isset($tenLoai)) {
            return response()->json([
                'status' => 'error',
                'errors' => "Loại đã tồn tại"
            ], 422);
        };
        $this->loaiServices->ThemLoai($request->ten, $request->sizeDuyNhat);
        return response([
            'message' => 'thanh cong'
        ], 200);
    }

    public function Xoa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'id.required' => 'Không tìm thấy id loại',
            'id.integer' => 'Tên loại phải là số 0-9',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $kiemTra = $this->loaiServices->TimIDMon($request->id);
        if (isset($kiemTra)) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'Có món thuộc loại này không thể xoá'
            ], 422);
        }


        if ($this->loaiServices->XoaLoai($request->id) == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'không tìm thấy loại'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }

    public function Sua(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:255',
        ], [
            'ten.required' => 'vui lòng nhập tên',
            'ten.string' => 'Tên loại phải là chữ a-z hoặc 0-9',
            'ten.max' => 'nhiều nhất 255 ký tự'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tenLoai = $this->loaiServices->TimTen($request->ten);

        if (isset($tenLoai)) {
            return response()->json([
                'status' => 'error',
                'errors' => "Loại đã tồn tại"
            ], 422);
        };


        if ($this->loaiServices->SuaLoai($request->ten, $request->id) == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'không tìm thấy loại'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }
}
