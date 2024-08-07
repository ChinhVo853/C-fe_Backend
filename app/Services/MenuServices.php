<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MenuServices
{
    public function XemMenu()
    {
        $data =
            DB::table('mon_an as m')
            ->join('loai as l', 'l.id', '=', 'm.loai_id')
            ->join('size as s', 's.id', '=', 'm.size_id')
            ->select(
                'm.id as mon_id',
                'm.ten as ten_mon',
                'l.ten as ten_loai',
                'm.gia',
                's.ten as ten_size',
                'm.anh',
                'm.trang_thai'
            )
            ->where('trang_thai', 0)
            ->orderBy('l.id', 'asc')
            ->orderBy('m.id', 'asc')
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


    public function TimMon(string $tenMon, $size)
    {

        $monAn = DB::table('mon_an as ma')
            ->select('ma.id')
            ->join('size as s', 's.id', '=', 'ma.size_id')
            ->where('ma.ten', $tenMon)
            ->where('s.ten', $size)
            ->first();
        return $monAn;
    }



    public function ThemMon(int $datMonID, int $soLuong, int $monID)
    {
        DB::table('chi_tiet_dat_mon')
            ->insert([
                'dat_mon_id' => $datMonID,
                'mon_an_id'  => $monID,
                'so_luong' => $soLuong,
                'xac_nhan_dat_mon' => 0,
                'xac_nhan_thanh_toan' => 0
            ]);
    }

    public function TimDatMon(int $id)
    {
        $data = DB::table('dat_mon')
            ->select('id')
            ->where('ban_id', '=', $id)
            ->orderBy('id', 'desc')
            ->first();
        return $data;
    }

    public function DSChiTietDatMon(int $id)
    {
        $data = DB::table('chi_tiet_dat_mon as ctdm')
            ->join('mon_an as m', 'm.id', '=', 'ctdm.mon_an_id')
            ->join('size as s', 's.id', '=', 'm.size_id')
            ->where('ctdm.dat_mon_id', '=', $id)
            ->where('ctdm.xac_nhan_dat_mon', '=', 0)
            ->select(
                'm.ten as ten_mon',
                'm.gia',
                's.ten as ten_size',
                'so_luong',
                'm.anh'
            )
            ->get();
        return $data;
    }
    public function KiemTraBan(int $ban)
    {
        $data = DB::table('ban')
            ->where('id', $ban)
            ->select('trang_thai_id')
            ->first();
        return $data;
    }

    public function TimCTDM(int $monID, int $datMonID)
    {
        $data = DB::table('chi_tiet_dat_mon')
            ->where('mon_an_id', $monID)
            ->where('dat_mon_id', $datMonID)
            ->where('xac_nhan_dat_mon', 0)
            ->select('id')
            ->first();
        return $data;
    }

    public function ThemSoLuong(int $monID, int $datMonID)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('mon_an_id', $monID)
            ->where('dat_mon_id', $datMonID)
            ->update([
                'so_luong' => DB::raw('so_luong + 1')
            ]);
    }

    public function GiamSoLuong(int $monID, int $datMonID)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('mon_an_id', $monID)
            ->where('dat_mon_id', $datMonID)
            ->update([
                'so_luong' => DB::raw('so_luong - 1')
            ]);
    }

    public function KiemTraSL(int $monID, int $datMonID)
    {
        $data = DB::table('chi_tiet_dat_mon')
            ->where('mon_an_id', $monID)
            ->where('dat_mon_id', $datMonID)
            ->select('so_luong')
            ->first();
        return $data;
    }

    public function Xoa(int $monID, int $datMonID)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('mon_an_id', $monID)
            ->where('dat_mon_id', $datMonID)
            ->delete();
    }
}
