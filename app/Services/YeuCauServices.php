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
                'b.id as ban_id',
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
            ->orderBy('id', 'desc')
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
                'ct.thanh_tien'
            )
            ->get();

        // Tính lại tổng tiền từ ct.thanh_tien
        $tongTien = $data->sum('thanh_tien');

        // Chuyển đổi dữ liệu thành mảng để thêm tổng tiền
        $data = $data->toArray();
        DB::table('hoa_don')
            ->where('id', $id)
            ->update([
                'tong_tien' => $tongTien
            ]);

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
                'ct.xac_nhan',
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
    public function TimKTHoaDon(int $id, int $datMon)
    {
        $tim = DB::table('hoa_don')
            ->select('id')
            ->where('ban_id', $id)
            ->where('dat_mon_id', $datMon)
            ->orderBy('id', 'desc')

            ->first();
        return $tim;
    }

    public function TaoHoaDon(int $id, int $ban, float $tongTien)
    {

        $data = DB::table('hoa_don')
            ->insertGetId([
                'dat_mon_id' => $id,
                'tong_tien' => $tongTien,
                'ban_id' => $ban
            ]);
        return $data;
    }

    public function TaoCTHoaDon(int $hoaDonID, int $monAnID, int $soLuong, float $thanhTien)
    {
        DB::table('chi_tiet_hoa_don')
            ->insert([
                'hoa_don_id' => $hoaDonID,
                'mon_an_id' => $monAnID,
                'so_luong' => $soLuong,
                'thanh_tien' => $thanhTien
            ]);
    }

    public function TimCTDM(int $id)
    {
        $data = DB::table('chi_tiet_dat_mon as ctdm')
            ->join('mon_an as m', 'm.id', '=', 'ctdm.mon_an_id')
            ->where('dat_mon_id', $id)
            ->select(
                'ctdm.mon_an_id',
                'ctdm.so_luong',
                'm.gia'
            )
            ->get();
        return $data;
    }
}
/**/