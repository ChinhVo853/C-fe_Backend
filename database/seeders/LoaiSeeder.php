<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('loai')
            ->insert([
                'ten' => 'Cà phê',
                'size_duy_nhat' => false
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Trà sữa',
                'size_duy_nhat' => false
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Hồng trà',
                'size_duy_nhat' => false
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Sinh tố',
                'size_duy_nhat' => false
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Nước ép',
                'size_duy_nhat' => false
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Đồ uống đóng chai',
                'size_duy_nhat' => true
            ]);


        DB::table('loai')
            ->insert([
                'ten' => 'Bánh tráng',
                'size_duy_nhat' => true
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Đồ chiên',
                'size_duy_nhat' => true
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Gà rán',
                'size_duy_nhat' => true
            ]);

        DB::table('loai')
            ->insert([
                'ten' => 'Bánh đóng gói sẵn',
                'size_duy_nhat' => true
            ]);
    }
}
