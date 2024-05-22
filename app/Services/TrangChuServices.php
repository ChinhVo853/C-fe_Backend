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

    public function LuuLichSuBan($requestData, $tongTien)
    {
        return DB::table('lich_su_ban')
            ->insertGetId([
                'ban_id'    => $requestData->ban_id,
                'tong_tien' => $tongTien,
                'thong_tin' => $requestData->thong_tin
            ]);
    }

    public function LuuChiTietBan($requestData, $lichSuBanId)
    {
        $tongTien = 0;

        foreach ($requestData->ten as $key => $value) {
            DB::table('chi_tiet_ban')
                ->insert([
                    'id_mon'         => $requestData->mon_id[$key],
                    'id_ban'         => $requestData->ban_id,
                    'lich_su_ban_id' => $lichSuBanId,
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
        $tongTien = DB::table('lich_su_ban')
            ->where('id', '=', $lichSuBanId)
            ->update([
                'tong_tien' => $tongTien
            ]);
    }

    public function XemLichSuMon($thongTin)
    {

        $lichSuMon = DB::table('lich_su_ban as lsb')
            ->join('ban as b', 'lsb.ban_id', '=', 'b.id')
            ->where('lsb.thong_tin', '=', $thongTin)
            ->select(
                'lsb.thong_tin',
                'lsb.tong_tien',
                'b.ten'
            )
            ->orderBy('lsb.created_at', 'desc')
            ->get();
        return $lichSuMon;
    }

    public function XemChiTietLichSuMon($BanID)
    {
        $dsChiTietLichSu = DB::table('lich_su_ban as lsb')
            ->join('chi_tiet_ban as ctb', 'lsb.id', '=', 'ctb.lich_su_ban_id')
            ->join('ban as b', 'lsb.ban_id', '=', 'b.id')
            ->join('mon as m', 'ctb.id_mon', '=', 'm.id')
            ->where('lsb.id', '=', $BanID)
            ->select(
                'm.ten as ten_mon',
                'b.ten as ten_ban',
                'ctb.thanh_tien',
                'ctb.so_luong',
                'ctb.ghi_chu',
                'lsb.thong_tin'
            )->get();
        return $dsChiTietLichSu;
    }

    public function GoiNhanVienBan($banID)
    {
        DB::table('ban')
            ->where('id', '=', $banID)
            ->update(['trang_thai' => 2]);
    }
}
