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
            ->where('size_id', $size)
            ->where('loai_id', $loai)
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
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID'
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
                'm.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID'
            ])
            ->orderBy('l.id', 'asc')
            ->get();
        return $data;
    }


    public function SuaTrangThai(int $id, int $trangThai)
    {
        DB::table('mon_an')
            ->where('id', $id)
            ->update([
                'trang_thai' => $trangThai
            ]);
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

    public function XoaMon($id)
    {

        $data = DB::table('mon_an')
            ->where('id', '=', $id)
            ->select('id')->get();
        if ($data->count() > 0) {
            DB::table('mon_an')
                ->where('id', $id)
                ->delete();
            return 1;
        }
        return 0;
    }

    public function Tim($tim)
    {
        $data = DB::table('mon_an as ma')
            ->join('loai as l', 'ma.loai_id', '=', 'l.id')
            ->join('size as s', 'ma.size_id', '=', 's.id')
            ->select([
                'ma.id as id',
                'ma.ten as tenMon',
                'l.ten as tenLoai',
                's.ten as tenSize',
                'ma.gia',
                'ma.anh',
                'ma.trang_thai',
                's.id as sizeID',
                'l.id as LoaiID'
            ])
            ->where(function ($query) use ($tim) {
                $query->whereRaw("BINARY ma.ten LIKE '%{$tim}%'")
                    ->orWhereRaw("BINARY l.ten LIKE '%{$tim}%'");
            })
            ->orderBy('l.id', 'asc')
            ->get();

        return $data;
    }
}
