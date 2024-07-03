<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class YeuCauServices
{
    public function XemDS($id)
    {
        $data = DB::table('yeu_cau as yc')
            ->join('dat_mon as dm', 'dm.id', 'yc.dat_mon_id')
            ->join('ban as b', 'b.id', 'dm.ban_id')
            ->where('dat_mon_id', $id)
            ->select(
                'b.ten_ban',
                'yc.noi_dung',
                'yc.trang_thai',
                'yc.created_at as thoi_gian'
            )
            ->get();
        return $data;
    }
    public function XemTatCa()
    {
        $data = DB::table('yeu_cau as yc')
            ->join('dat_mon as dm', 'dm.id', 'yc.dat_mon_id')
            ->join('ban as b', 'b.id', 'dm.ban_id')
            ->select(
                'yc.id as yeu_cau_id',
                'b.ten_ban',
                'yc.noi_dung',
                'yc.trang_thai',
                'yc.created_at as thoi_gian'
            )
            ->get();
        return $data;
    }

    public function XacNhan($id)
    {
        DB::table('yeu_cau')
            ->where('id', $id)
            ->update([
                'trang_thai' => 1
            ]);
    }
    public function TimDatMon($banID)
    {
        $data = DB::table('dat_mon')
            ->select('id')
            ->where('ban_id', $banID)
            ->first();
        return $data;
    }

    public function Tao(int $datMon, string $noiDung)
    {
        DB::table('yeu_cau')
            ->insert([
                'dat_mon_id' => $datMon,
                'noi_dung' => $noiDung,
                'trang_thai' => 0
            ]);
    }

    public function KTTrangThaiBan(int $ban)
    {
        $data = DB::table('ban')
            ->select('trang_thai_id')
            ->where('id', $ban)
            ->first();
        return $data;
    }

    public function DoiThanhToan(int $ban)
    {
        DB::table('ban')
            ->where('id', $ban)
            ->update([
                'trang_thai_id' => 3
            ]);
    }

    public function SuaThanhToan(string $noiDung)
    {
        DB::table('yeu_cau')
            ->where('noi_dung', 'LIKE', '%Thanh Toán%')
            ->update(['noi_dung' => $noiDung]);
    }

    public function TimYeuCauMoiBan(int $dat_mon_id)
    {
        $noidungyeucau=DB::table('yeu_cau as yc')
        ->join('dat_mon as dm', 'dm.id', 'yc.dat_mon_id')
        ->join('ban as b', 'b.id', 'dm.ban_id')
        ->select(
            'yc.id as yeu_cau_id',
            'b.ten_ban',
            'yc.noi_dung',
            'yc.trang_thai',
            'yc.created_at as thoi_gian'
        )
            ->where('dat_mon_id',$dat_mon_id)->get();
        return $noidungyeucau;
    }
}
