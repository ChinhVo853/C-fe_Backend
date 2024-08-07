<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nguoi_dung')
            ->insert([
                'ho_ten' => 'Admin',
                'email' => 'chinhvo853@gmail.com',
                'password' => Hash::make('12345678'),
                'so_dien_thoai' => '0987654321',
                'quyen_id' => 1
            ]);
        DB::table('nguoi_dung')
            ->insert([
                'ho_ten' => 'Lê Gia Bảo	',
                'email' => 'legiabao0910303@gmail.com',
                'password' => Hash::make('123456789'),
                'so_dien_thoai' => '0123456789',
                'quyen_id' => 2
            ]);
    }
}
