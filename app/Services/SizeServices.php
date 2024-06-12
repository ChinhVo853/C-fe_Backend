<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SizeServices
{
    public function ThemSize(string $size)
    {
        DB::table('size')
            ->insert(['ten' => $size]);
    }
}
