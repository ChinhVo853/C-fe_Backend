<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LoaiServices
{
    public function ThemLoai(string $ten)
    {
        DB::table('loai')
            ->insert(['ten' => $ten]);
    }
}
