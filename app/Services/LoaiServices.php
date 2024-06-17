<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LoaiServices
{
    public function XemLoai()
    {
        $data = DB::table('loai')
            ->select('ten', 'size_duy_nhat')->get();
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
            ->select('ten')->get();
        return $data;
    }
}
