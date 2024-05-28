<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MenuServices
{
    public function XemMenu()
    {
        $data =
            DB::table('mon as m')
            ->join('loai as l', 'l.id', '=', 'm.loai_id')
            ->join('chi_tiet_mon as ctm', 'ctm.mon_id', '=', 'm.id')
            ->join('size as s', 's.id', '=', 'ctm.size_id')
            ->select(
                'm.id as mon_id',
                'm.ten as ten_mon',
                'l.ten as ten_loai',
                'm.gia',
                's.ten as ten_size'
            )
            ->get();
        return $data;
    }

    public function TaoHoaDon($requestData)
    {
        return DB::table('hoa_don')
            ->insertGetId([
                'ban_id'    => $requestData->ban_id,
                'tong_tien' => 0,
                'thong_tin' => $requestData->thong_tin
            ]);
    }

    public function LuuChiTietBan($requestData, $lichSuBanId)
    {
        $tongTien = 0;

        foreach ($requestData->ten as $key => $value) {
            DB::table('chi_tiet_hoa_don')
                ->insertGetId([
                    'id_mon'         => $requestData->mon_id[$key],
                    'id_ban'         => $requestData->ban_id,
                    'hoa_don_id' => $lichSuBanId,
                    'so_luong'       => $requestData->so_luong[$key],
                    'thanh_tien'     => $requestData->so_luong[$key] * $requestData->gia[$key],
                    'ghi_chu'        => $requestData->ghi_chu
                ]);
            $tongTien += $requestData->so_luong[$key] * $requestData->gia[$key];
        }

        return $tongTien;
    }


    public function CapNhatTongTienLS($tongTien, $lichSuBanId)
    {
        $tongTien = DB::table('hoa_don')
            ->where('id', '=', $lichSuBanId)
            ->update([
                'tong_tien' => $tongTien
            ]);
    }

    public function CapNhatBan($banID, $hoaDon)
    {
        DB::table('ban')
            ->where('id', '=', $banID)
            ->update(['hoa_don_id' => $hoaDon]);
    }
}
