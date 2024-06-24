<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatMonServices
{
    public function Tao(int $ban)
    {
        $kiemTra = $this->KiemTraBanTrong($ban);
        if ($kiemTra->trang_thai_id == 1) {
            $banID = DB::table('dat_mon')
                ->insertGetId([
                    'ban_id' => $ban,
                ]);
            $this->MoBan($ban);
            return $banID;
        }
        return 0;
    }

    public function MoBan(int $ban)
    {
        DB::table('ban')
            ->where('id', '=', $ban)
            ->update(['trang_thai_id' => 2]);
    }

    public function KiemTraBanTrong(int $ban)
    {
        $data = DB::table('ban')
            ->select('trang_thai_id')
            ->where('id', '=', $ban)->first();
        return $data;
    }

    public function TimMa(int $ma)
    {
        $data = DB::table('dat_mon')
            ->select('id')
            ->where('id', '=', $ma)
            ->first();
        return $data->id;
    }
}
