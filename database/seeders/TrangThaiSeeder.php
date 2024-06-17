<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrangThaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trang_thai')
            ->insert([
                'ten' => 'trống',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'mở',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'chờ thanh toán',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'dọn bàn',
            ]);
    }
}
