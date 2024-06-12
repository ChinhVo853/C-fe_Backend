<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SanPhamServices
{
    public function ThemMon(string $ten, int $LoaiID, int $gia, int $sizeID)
    {
        $mon = DB::table('mon')
            ->insertGetId([
                'ten'         => $ten,
                'loai_id'     => $LoaiID,
                'size_id'     => $sizeID,
                'gia'         => $gia
            ]);
        return $mon;
    }

    public function ThemChiTietMon(int $monID, array $soLuongNguyenLieu, array $nguyenLieuID)
    {

        foreach ($nguyenLieuID as $key => $value) {
            DB::table('chi_tiet_mon')
                ->insertGetId([
                    'mon_id'                   => $monID,
                    'so_luong_nguyen_lieu'    => $soLuongNguyenLieu[$key],
                    'nguyen_lieu_id'          => $value
                ]);
        }
    }

    public function ThemAnhMon(int $monID, string $imageName)
    {
        DB::table('mon')
            ->where('id', $monID)
            ->update([
                'anh' => $imageName
            ]);
    }


    public function XemMon()
    {
        $data = DB::table('mon as m')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.í')
            ->select([
                'id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.tem as tenSize'
            ])->get();
        return $data;
    }

    public function XemLoai()
    {
        $data = DB::table('loai')
            ->select([
                'id',
                'ten',
            ])->get();
        return $data;
    }

    public function XemSize()
    {
        $data = DB::table('size')
            ->select([
                'id',
                'ten',
            ])->get();
        return $data;
    }
}
