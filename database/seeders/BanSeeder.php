<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 1',
                'trang_thai_id' => 1
            ]);
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 2',
                'trang_thai_id' => 1
            ]);
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 3',
                'trang_thai_id' => 1
            ]);
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 4',
                'trang_thai_id' => 1
            ]);
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 5',
                'trang_thai_id' => 1
            ]);
        DB::table('ban')
            ->insert([
                'ten_ban' => 'Bàn 6',
                'trang_thai_id' => 1
            ]);
    }
}
