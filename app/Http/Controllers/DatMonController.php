<?php

namespace App\Http\Controllers;

use App\Services\DatMonServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DatMonController extends Controller
{
    protected $DatMonServices;
    public function __construct(DatMonServices $DatMonServices)
    {
        $this->DatMonServices = $DatMonServices;
    }
    //
    public function TaoDatMon(int $id)
    {
        $data = $this->DatMonServices->Tao($id);
        if ($data == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'Bàn đã mở'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ], 200);
    }

    public function KiemTraMaBan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma' => 'required|integer',

        ], [
            'ma.required' => 'vui lòng nhập mã',
            'ma.integer' => 'Mã phải là số 0-9',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $this->DatMonServices->TimMa($request->ma);

        if (!isset($data)) {
            return response()->json([
                'message' => 'Thất Bại',
                'errors' => "Mã không đúng"
            ], 200);
        }
        return response()->json([
            'message' => 'Thành công',
            'data' => $data
        ], 200);
    }
}
