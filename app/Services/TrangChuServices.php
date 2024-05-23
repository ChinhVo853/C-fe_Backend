<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TrangchuServices
{
    public function NhapThongTinBan($banID, $thongTin)
    {
        DB::table('ban')
            ->where('id', '=', $banID)
            ->update(['thong_tin' => $thongTin]);
    }

    public function layThongTinBan($banID)
    {
        $thongTin = DB::table('ban as b')
            ->join('thong_tin_quan as ttq', 'b.thong_tin_quan_id', '=', 'ttq.id')
            ->where('b.id', '=', $banID)
            ->select(
                'ttq.ten as ten_quan',
                'b.ten as ten_ban',
                'ttq.thu_hai',
                'ttq.thu_ba',
                'ttq.thu_tu',
                'ttq.thu_nam',
                'ttq.thu_sau',
                'ttq.thu_bay',
                'ttq.chu_nhat',
                'b.thong_tin'
            )
            ->get();

        return $thongTin;
    }

    public function XemLichSuMon($thongTin)
    {

        $lichSuMon = DB::table('hoa_don as hd')
            ->join('ban as b', 'hd.ban_id', '=', 'b.id')
            ->where('hd.thong_tin', '=', $thongTin)
            ->select(
                'hd.thong_tin',
                'hd.tong_tien',
                'b.ten'
            )
            ->orderBy('hd.created_at', 'desc')
            ->get();
        return $lichSuMon;
    }

    public function XemChiTietLichSuMon($BanID)
    {
        $dsChiTietLichSu = DB::table('hoa_don as hd')
            ->join('chi_tiet_hoa_don as cthd', 'hd.id', '=', 'cthd.hoa_don_id')
            ->join('ban as b', 'hd.ban_id', '=', 'b.id')
            ->join('mon as m', 'cthd.id_mon', '=', 'm.id')
            ->where('hd.id', '=', $BanID)
            ->select(
                'm.ten as ten_mon',
                'b.ten as ten_ban',
                'cthd.thanh_tien',
                'cthd.so_luong',
                'cthd.ghi_chu',
                'hd.thong_tin'
            )->get();
        return $dsChiTietLichSu;
    }

    public function GoiNhanVienBan($banID)
    {
        DB::table('ban')
            ->where('id', '=', $banID)
            ->update(['trang_thai' => 2]);
    }

    public function GoiThanhToanBan($banID)
    {
        DB::table('ban')
            ->where('id', '=', $banID)
            ->update(['trang_thai' => 3]);
    }
}
