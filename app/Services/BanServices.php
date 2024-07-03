<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BanServices
{
    public function XemDS()
    {
        $data = DB::table('ban as b')
            ->join('trang_thai as tt', 'b.trang_thai_id', 'tt.id')
            ->leftJoin('dat_mon as dm', 'dm.ban_id', 'b.id')
            ->select(
                'b.id as ban_id',
                'dm.id as dat_mon_id',
                'b.ten_ban as ten_ban',
                'tt.ten as ten_trang_thai'
            )
            ->get();
        return $data;
    }

    public function XoaBan($id)
    {
        DB::table('ban')
            ->where('id', $id)
            ->delete();
    }
    public function TimTenBan(string $ten_ban)
    {
        $data = DB::table('ban')->select('ten_ban')
            ->where('ten_ban', '=', $ten_ban)->first();
        return ($data);
    }
    public function ThemBan(string $ten_ban)
    {
        DB::table('ban')
            ->insert([
                'ten_ban' => $ten_ban,
                'trang_thai_id' => 1
            ]);
    }
    /**/
}
