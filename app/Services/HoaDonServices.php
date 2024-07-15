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
            ->orderBy('id', 'desc')
            ->first();
        return $data;
    }
    public function LayDSCTDatMon(int $id)
    {
        $data = DB::table('chi_tiet_dat_mon as ct')
            ->join('mon_an as m', 'm.id', 'ct.mon_an_id')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.id')
            ->where('xac_nhan_dat_mon', 1)
            ->where('dat_mon_id', $id)
            ->select([
                'ct.id as chiTietID',
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID',
                'ct.so_luong',
                'ct.xac_nhan_dat_mon',
                'ct.xac_nhan_thanh_toan'
            ])->get();
        return $data;
    }
    public function LayTatCaDSCTDatMon(int $id)
    {
        $data = DB::table('chi_tiet_dat_mon as ct')
            ->join('mon_an as m', 'm.id', 'ct.mon_an_id')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.id')
            ->where('dat_mon_id', $id)
            ->where('xac_nhan_dat_mon', 1)
            ->select([
                'ct.id as chiTietID',
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID',
                'ct.so_luong',
                'ct.xac_nhan_dat_mon',
                'ct.xac_nhan_thanh_toan'
            ])->get();
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
                'ct.id as chiTietID',
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'ct.thanh_tien',
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID',
                'ct.so_luong',
                'hd.tong_tien',
                'hd.created_at',
                'hd.updated_at'
            ])->get();
        return $data;
    }
    public function TimHoaDon(int $id, int $datMon)
    {
        $tim = DB::table('hoa_don')
            ->select('id')
            ->where('ban_id', $id)
            ->where('dat_mon_id', $datMon)
            ->orderBy('id', 'desc')

            ->first();
        return $tim;
    }
    public function TimVaTaoHoaDon(int $id, int $ban)
    {
        $tim = DB::table('hoa_don')
            ->select('id')
            ->where('id', $id)
            ->first();

        if (!isset($tim)) {
            $data = DB::table('hoa_don')
                ->insertGetId([
                    'dat_mon_id' => $id,
                    'tong_tien' => 0,
                    'ban_id' => $ban
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
                'xac_nhan' => 0,
                'thanh_tien' => $thanhTien
            ]);
    }

    public function capNhatTongTien(int $hoaDonID, float $tongTien)
    {
        DB::table('hoa_don')
            ->where('id', $hoaDonID)
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

    public function LayDSHoaDon(int $id)
    {
        $data = DB::table('hoa_don as hd')
            ->join('ban as b', 'b.id', '=', 'hd.ban_id')
            ->where('hd.ban_id', $id)
            ->select([
                'hd.id',
                'b.ten_ban',
                'hd.tong_tien',
                'hd.created_at',
            ])
            ->orderByDesc('hd.id')->get();
        return $data;
    }

    public function ChiTietXacNhan(int $id)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('id', $id)
            ->update([
                'xac_nhan_thanh_toan' => 1
            ]);
    }
    public function TimNgayHD(string $ngayDB, string $ngayKT, int $id)
    {
        $data = DB::table('hoa_don')
            ->where('ban_id', $id)
            ->whereBetween('created_at', [$ngayDB, $ngayKT])
            ->select([
                'id',
                'tong_tien',
                'created_at',
            ])->get();
        return $data;
    }


    public function XacNhanDatMon(int $id)
    {
        DB::table('chi_tiet_dat_mon')
            ->where('dat_mon_id', $id)
            ->update([
                'xac_nhan_dat_mon' => 1
            ]);
    }
}
