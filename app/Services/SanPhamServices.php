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


    public function XemNguyenLieu()
    {
        $data = DB::table('nguyen_lieu')
            ->select([
                'id',
                'ten',
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
