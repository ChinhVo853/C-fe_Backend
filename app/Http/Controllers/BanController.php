<?php

namespace App\Http\Controllers;

use App\Services\BanServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BanController extends Controller
{
    protected $BanServices;
    public function __construct(BanServices $BanServices)
    {
        $this->BanServices = $BanServices;
    }

    public function DanhSachBan()
    {
        $data = $this->BanServices->XemDS();
        return response()->json([
            'message' =>  'Thành công',
            'data' => $data
        ], 200);
    }

    public function Xoa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'id.required' => 'vui lòng nhập mã',
            'id.integer' => 'Mã phải là số 0-9',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $this->BanServices->XoaBan($request->id);
        return response()->json([
            'message' => 'Thành công',
        ], 200);
    }

    public function Them(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten_ban' => 'required|string|max:100',

        ], [
            'ten_ban.required' => 'Vui lòng nhập tên bàn',
            'ten_ban.string' => 'Tên bàn phải là chữ a-z hoặc 0-9',
            'ten_ban.max' => 'Nhiều nhất 100 ký tự',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $tenBan = $this->sizeServices->TimTenBan($request->ten_ban);

        if (isset($tenBan)) {
            return response()->json([
                'status' => 'error',
                'errors' => "Bàn đã tồn tại"
            ], 422);
        };


        $this->BanServices->ThemBan($request->ten_ban);
        return response([
            'message' => "thành công",
        ]);
        /**/
    }
}
