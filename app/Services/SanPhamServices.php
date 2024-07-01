<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SanPhamServices
{
    public function ThemMon(string $ten, int $LoaiID, int $gia, int $sizeID, string $foodStatus)
    {
        if ($foodStatus == "Hết hàng") {
            $trangThai = 0;
        } else {
            $trangThai = 1;
        }
        $mon = DB::table('mon_an')
            ->insertGetId([
                'ten'         => $ten,
                'loai_id'     => $LoaiID,
                'size_id'     => $sizeID,
                'gia'         => $gia,
                'so_luong_danh_gia'  => 0,
                'trang_thai' => $trangThai

            ]);
        return $mon;
    }

    public function TimMon(string $ten, int $size, int $loai)
    {
        $mon = DB::table('mon_an')
            ->where('ten', $ten)
            ->select('id')
            ->get();

        return $mon;
    }

    public function TimTungMon(int $id)
    {
        $mon = DB::table('mon_an as m')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.id')
            ->where('m.id', $id) // Use 'm.id' instead of just 'id'
            ->select([
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'm.so_luong_danh_gia',
                'm.trang_thai'
            ])
            ->first();

        return $mon;
    }




    public function ThemAnhMon(int $monID, string $imageName)
    {
        DB::table('mon_an')
            ->where('id', $monID)
            ->update([
                'anh' => $imageName
            ]);
    }


    public function XemMon()
    {
        $data = DB::table('mon_an as m')
            ->join('loai as l', 'm.loai_id', 'l.id')
            ->join('size as s', 'm.size_id', 's.id')
            ->select([
                'm.id as id',
                'm.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'm.gia',
                'm.anh',
                'm.so_luong_danh_gia',
                'm.trang_thai'
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


    public function SuaMon(string $ten, int $id, float $gia, int $trangThai)
    {
        DB::table('mon_an')
            ->where('id', $id)
            ->update([
                'ten' => $ten,
                'gia' => $gia,
                'trang_thai' => $trangThai
            ]);
    }
}
