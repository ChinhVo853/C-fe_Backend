<?php

namespace App\Http\Controllers;

use App\Services\YeuCauServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class YeuCauConTRoller extends Controller
{
    protected $YeuCauServices;
    public function __construct(YeuCauServices $YeuCauServices)
    {
        $this->YeuCauServices = $YeuCauServices;
    }

    public function XemDS($ban)
    {
        $datMonID = $this->YeuCauServices->TimDatMon($ban);
        if (!isset($datMonID)) {
            return response()->json([
                'message' => 'Không có ',

            ], 200);
        }
        $data = $this->YeuCauServices->XemDS($datMonID->id);
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ], 200);
    }

    public function XemYeuCau()
    {
        $data = $this->YeuCauServices->XemTatCa();
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ], 200);
    }

    public function TaoYeuCau(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ban' => 'required|integer',
            'yeuCau' => 'required|string|max:100',
            'noiDung' => 'required|string|max:500',
        ], [
            'ban.required' => 'vui lòng nhập mã',
            'ban.integer' => 'Mã phải là số 0-9',
            'yeuCau.required' => 'vui lòng nhập yêu cầu',
            'yeuCau.string' => 'Yêu cầu phải là chữ a-z hoặc 0-9',
            'yeuCau.max' => 'nhiều nhất 100 ký tự',
            'noiDung.required' => 'vui lòng nhập Nội dung',
            'noiDung.string' => 'nội dung phải là chữ a-z hoặc 0-9',
            'noiDung.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $datMonID = $this->YeuCauServices->TimDatMon($request->ban);
        $trangThaiBan = $this->YeuCauServices->KTTrangThaiBan($request->ban);
        if ($trangThaiBan->trang_thai_id == 3) {
            if ($request->yeuCau == "Thanh toán") {
                $this->YeuCauServices->SuaThanhToan($request->noiDung);
                return response()->json([
                    'message' => 'thanh cong',

                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'errors' => "bàn đang chờ thanh toán"
            ], 200);
        }
        if ($request->yeuCau == "Thanh toán") {
            $this->YeuCauServices->DoiThanhToan($request->ban);
        }
        $this->YeuCauServices->Tao($datMonID->id, $request->noiDung);
        return response()->json([
            'message' => 'thanh cong',

        ], 200);
    }

    public function XacNhanYeuCau($id)
    {
        $this->YeuCauServices->XacNhan($id);
        return response()->json([
            'message' => 'thanh cong',

        ], 200);
    }
}
