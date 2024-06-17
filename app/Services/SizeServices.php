<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SizeServices
{
    public function XemSize()
    {
        $data = DB::table('size')->select('id', 'ten')->get();
        return $data;
    }
    public function ThemSize(string $ten)
    {
        DB::table('size')
            ->insert(['ten' => $ten]);
    }

    public function TimTen(string $ten)
    {
        $data = DB::table('size')->select('ten')
            ->where('ten', '=', $ten)->get();
        return ($data);
    }

    public function SuaSize(string $ten, int $id)
    {
        $data = DB::table('size')
            ->where('id', '=', $id)
            ->select('id')->get();

        if ($data->count() > 0) {
            DB::table('size')
                ->where('id', '=', $id)
                ->update(['ten' => $ten]);
            return 1;
        }
        return 0;
    }

    public function XoaSize(int $id)
    {
        $data = DB::table('size')
            ->where('id', '=', $id)
            ->select('id')->get();
        if ($data->count() > 0) {
            DB::table('size')
                ->where('id', '=', $id)
                ->delete();
            return 1;
        }
        return 0;
    }
}
