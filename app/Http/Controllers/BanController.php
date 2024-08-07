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

        //  dd($data);
        foreach ($data as $item) {

            $tam = 0;
            $tam2 = 0;
            $datMon = $this->BanServices->TimDatMon($item->ban_id);
            if (isset($datMon)) {
                $hoadon = $this->BanServices->TimCTDatMon($datMon->id);
                if (isset($hoadon)) {
                    foreach ($hoadon as $item2) {
                        if ($item2->xac_nhan_dat_mon == 1) {
                            $tam2++;
                        }
                    }
                    $item->hd = $tam2;
                }
                $yeuCAu = $this->BanServices->TimYeuCau($datMon->id);

                if (isset($yeuCAu)) {
                    foreach ($yeuCAu as $item2) {
                        if ($item2->trang_thai == 0) {
                            $tam++;
                        }
                    }
                    $item->yeuCau = $tam;
                }
            }
        }

        return response()->json([
            'message' => 'Thành công',
            'data' => $data,
        ], 200);
    }

    public function DSTrangThaiBan($id)
    {
        $data = $this->BanServices->DSTrangThai($id);
        return response()->json([
            'message' =>  'Thành công',
            'data' => $data
        ], 200);
    }
    public function LamTrong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dat_mon_id' => 'required',
        ], [
            'dat_mon_id.required' => 'Bàn đang trống',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $ban = $this->BanServices->TimTrangThaiBan($request->ban);

        $hd = $this->BanServices->TimHD($request->dat_mon_id);

        if ($ban->trang_thai_id == 1) {
            return response()->json([
                'status' => 'error',
                'errors' => "Bàn đang trống"
            ], 422);
        }

        if (isset($hd)) {
            if ($ban->trang_thai_id == 2 || $ban->trang_thai_id == 3) {
                $this->BanServices->xoaCTHD($hd->id);
                $this->BanServices->XoaHoaDon($hd->id);
            }
        }

        if (!isset($ban)) {
            return response()->json([
                'status' => 'error',
                'errors' => 'không tìm thấy bàn'
            ], 422);
        }


        $this->BanServices->XoaYeuCau($request->dat_mon_id);

        $data = $this->BanServices->LamBanTrong($request->ban);
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
        $datMon = $this->BanServices->TimDatMon($request->id);
        if (!empty($datMon)) {
            return response()->json([
                'status' => 'error',
                'errors' => "Không thể xoá"
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
        $tenBan = $this->BanServices->TimTenBan($request->ten_ban);

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

    public function Sua(Request $request)
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
        $tenBan = $this->BanServices->TimTenBan($request->ten_ban);

        if (isset($tenBan)) {
            return response()->json([
                'status' => 'error',
                'errors' => "Bàn đã tồn tại"
            ], 422);
        };


        $this->BanServices->SuaBan($request->ten_ban, $request->id);
        return response([
            'message' => "thành công",
        ]);
        /**/
    }

    public function Tim($id)
    {
        $data = $this->BanServices->TimBan($id);
        return response([
            'message' => "thành công",
            'data' => $data
        ]);
    }

    public function KiemTra($id)
    {
        $data = $this->BanServices->KiemTraBan($id);
        return response([
            'message' => "thành công",
            'data' => $data
        ]);
    }

    public function TimMa($id)
    {
        $data = $this->BanServices->TimMaBan($id);
        return response([
            'message' => "thành công",
            'data' => $data
        ]);
    }
}
