<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NguyenLieuServices
{
    public function ThemNguyenLieu(string $ten, int $donViID, int $soLuong)
    {
        DB::table('nguyen_lieu')
            ->insert([
                'ten'         => $ten,
                'don_vi_id'   => $donViID,
                'so_luong'    => $soLuong
            ]);
    }
}
