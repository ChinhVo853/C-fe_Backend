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

    public function timYeuCau($id)
    {
        $data =
            DB::table('yeu_cau')
            ->where('id', $id)
            ->select('noi_dung')
            ->first();
        return $data->noi_dung;
    }

    public function TimDatMon($banID)
    {
        $data = DB::table('dat_mon')
            ->select('id')
            ->where('ban_id', $banID)
            ->first();
        return $data->id;
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
        $noidungyeucau = DB::table('yeu_cau as yc')
            ->join('dat_mon as dm', 'dm.id', 'yc.dat_mon_id')
            ->join('ban as b', 'b.id', 'dm.ban_id')
            ->select(
                'yc.id as yeu_cau_id',
                'b.ten_ban',
                'yc.noi_dung',
                'yc.trang_thai',
                'yc.created_at as thoi_gian',
                'b.id as ban_id'
            )
            ->where('dat_mon_id', $dat_mon_id)->get();
        return $noidungyeucau;
    }


    public function DonBan($id)
    {
        DB::table('ban')
            ->where('id', $id)
            ->update([
                'trang_thai_id' => 4
            ]);
    }

    public function TimHoaDon(int $ban, int $datMon)
    {
        $data = DB::table('hoa_don')
            ->where('ban_id', $ban)
            ->where('dat_mon_id', $datMon)
            ->select('id')
            ->first();
        return $data->id;
    }

    public function XoaChiTiet($id)
    {
        DB::table('chi_tiet_hoa_don')
            ->where('hoa_don_id', $id)
            ->where('xac_nhan', 0)
            ->delete();
    }

    public function TimCTHoaDon(int $id)
    {
        $data = DB::table('chi_tiet_hoa_don as ct')
            ->join('mon_an as m', 'ct.mon_an_id', 'm.id')
            ->join('hoa_don as hd', 'ct.hoa_don_id', 'hd.id')
            ->where('ct.hoa_don_id', $id)
            ->where('xac_nhan', 1)
            ->select(
                'ct.id as chiTietID',
                'm.ten as tenMon',
                'hd.tong_tien',
            )
            ->get();
        return $data;
    }
}
/**/