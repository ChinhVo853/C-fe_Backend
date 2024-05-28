<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SanPhamServices
{
    public function ThemMon(string $ten, int $LoaiID, int $gia)
    {
        $mon = DB::table('mon')
            ->insertGetId([
                'ten'         => $ten,
                'loai_id'     => $LoaiID,
                'gia'         => $gia
            ]);
        return $mon;
    }

    public function ThemChiTietMon(int $monID, int $sizeID, array $soLuongNguyenLieu, array $nguyenLieuID)
    {

        foreach ($nguyenLieuID as $key => $value) {
            DB::table('chi_tiet_mon')
                ->insertGetId([
                    'mon_id'                   => $monID,
                    'size_id'                 => $sizeID,
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
}
