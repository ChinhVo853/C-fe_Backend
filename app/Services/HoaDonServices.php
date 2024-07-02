<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class HoaDonServices
{
    public function LayIDDatMon(int $ban)
    {
        $data = DB::table('dat_mon')
            ->where('ban_id', $ban)
            ->select('id')
            ->first();
        return $data;
    }
    public function LayDSCThoaDon(int $id)
    {
        $data = DB::table('chi_tiet_hoa_don as ct')
            ->join('mon_an as m', 'm.id', 'ct.mon_an_id')
            ->join('hoa_don as hd', 'hd.id', 'ct.hoa_don_id')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.id')
            ->where('hoa_don_id', $id)
            ->select([
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'm.so_luong_danh_gia',
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID',
                'ct.so_luong',
                'hd.tong_tien'
            ])->get();
        return $data;
    }
    public function TimVaTaoHoaDon($id)
    {
        $tim = DB::table('hoa_don')
            ->select('id')
            ->where('id', $id)
            ->first();

        if (!isset($tim)) {
            $data = DB::table('hoa_don')
                ->insertGetId([
                    'dat_mon_id' => $id,
                    'tong_tien' => 0
                ]);
            return $data;
        }

        return $tim->id;
    }

    public function LayCTDatMon($id)
    {
        $data = DB::table('chi_tiet_dat_mon as ct')
            ->join('mon_an as m', 'm.id', 'ct.mon_an_id')
            ->where('dat_mon_id', $id)
            ->select(
                'ct.id as id',
                'dat_mon_id',
                'mon_an_id',
                'so_luong',
                'm.gia as gia'
            )
            ->get();
        return $data;
    }

    public function LuuChiTietHoaDon(int $hoaDonID, int $monAnID, int $soLuong, float $thanhTien)
    {
        DB::table('chi_tiet_hoa_don')
            ->insert([
                'hoa_don_id' => $hoaDonID,
                'mon_an_id' => $monAnID,
                'so_luong' => $soLuong,
                'thanh_tien' => $thanhTien
            ]);
    }

    public function capNhatTongTien(int $hoaDonID, float $tongTien)
    {
        DB::table('hoa_don')
            ->select('id', $hoaDonID)
            ->update([
                'tong_tien' => $tongTien
            ]);
    }

    public function XoaChiTietDatMon(int $datMonID)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('dat_mon_id', $datMonID)
            ->delete();
    }


    public function LayTiongTien($id)
    {
        $data = DB::table('hoa_don')
            ->where('id', $id)
            ->select('tong_tien')
            ->first();
        return $data->tong_tien;
    }

    public function TrangThaiBan(int $ban)
    {
        $data = DB::table('ban')
            ->where('id', $ban)
            ->select('trang_thai_id')
            ->first();
        return $data->trang_thai_id;
    }
}
