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
                'ten' => 'Trống',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'Mở',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'Chờ thanh toán',
            ]);

        DB::table('trang_thai')
            ->insert([
                'ten' => 'Dọn bàn',
            ]);
    }
}
