<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LoaiServices
{
    public function XemLoai()
    {
        $data = DB::table('loai')
            ->select('id', 'ten', 'size_duy_nhat')->get();
        return $data;
    }
    public function ThemLoai(string $ten, bool $sizeDuyNhat)
    {
        DB::table('loai')
            ->insert([
                'ten' => $ten,
                'size_duy_nhat' => $sizeDuyNhat
            ]);
    }

    public function XemMoiLoai(int $id)
    {
        $data = DB::table('loai')
            ->where('id', $id)
            ->select('id', 'ten', 'size_duy_nhat')
            ->first();
        return $data;
    }
    public function SuaLoai(string $ten, int $id)
    {
        $data = DB::table('loai')
            ->where('id', '=', $id)
            ->select('id')->get();
        if ($data->count() > 0) {
            DB::table('loai')
                ->where('id', '=', $id)
                ->update(['ten' => $ten]);
            return 1;
        }
        return 0;
    }
    public function XoaLoai(int $id)
    {
        $data = DB::table('loai')
            ->where('id', '=', $id)
            ->select('id')->get();
        if ($data->count() > 0) {
            DB::table('loai')
                ->where('id', '=', $id)
                ->delete();
            return 1;
        }
        return 0;
    }

    public function TimTen(string $ten)
    {
        $data = DB::table('loai')
            ->where('ten', '=', $ten)
            ->select('ten')->first();
        return $data;
    }

    public function TimIDMon(int $id)
    {
        $data = DB::table('mon_an')
            ->where('loai_id', $id)
            ->select('id')
            ->first();
        return $data;
    }
}
