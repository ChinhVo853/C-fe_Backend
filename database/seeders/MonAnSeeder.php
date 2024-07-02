<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonAnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mon_an')
            ->insert([
                'ten' => 'Đen đá',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Đen đá',
                'gia' => 20000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 3,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sữa đá',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sữa đá',
                'gia' => 20000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 3,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bạc xỉu',
                'gia' => 20000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bạc xỉu',
                'gia' => 25000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 1,
                'size_id' => 3,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Thái xanh',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 2,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Thái đỏ',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 2,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Truyền thông',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 2,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Hồng trà sen',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 3,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Hồng trà dâu',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 3,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Hồng trà vải',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 3,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sinh tố bơ',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 4,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sinh tố dâu',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 4,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sinh tố xoài',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 4,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Sinh tố mãn cầu',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 4,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Nước ép dưa hấu',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 5,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Nước ép cam',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 5,
                'size_id' => 2,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Nước ép cà rốt',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 5,
                'size_id' => 2,
                'trang_thai' => false
            ]);



        DB::table('mon_an')
            ->insert([
                'ten' => 'Sting',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 6,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bò hút',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 6,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'C2',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 6,
                'size_id' => 1,
                'trang_thai' => false
            ]);



        DB::table('mon_an')
            ->insert([
                'ten' => 'pepsi',
                'gia' => 15000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 6,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Mì cay bò',
                'gia' => 35000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 7,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Mì cay hải sản',
                'gia' => 35000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 7,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Mì cay thập cẩm',
                'gia' => 45000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 7,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bánh tráng trộn',
                'gia' => 25000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 8,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bánh tráng cuốn',
                'gia' => 25000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 8,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Bánh tráng chấm',
                'gia' => 25000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 8,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Combo 1',
                'gia' => 45000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 9,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Combo 2',
                'gia' => 45000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 9,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Gà rán sốt cay',
                'gia' => 35000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 10,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Gà rán sốt ngọt',
                'gia' => 35000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 10,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Gà rán nguyên vị',
                'gia' => 35000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 10,
                'size_id' => 1,
                'trang_thai' => false
            ]);


        DB::table('mon_an')
            ->insert([
                'ten' => 'Thịt bò',
                'gia' => 10000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 11,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Tôm',
                'gia' => 10000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 11,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Cà tím',
                'gia' => 10000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 11,
                'size_id' => 1,
                'trang_thai' => false
            ]);

        DB::table('mon_an')
            ->insert([
                'ten' => 'Mỳ',
                'gia' => 7000,
                'so_luong_danh_gia' => 0,
                'loai_id' => 11,
                'size_id' => 1,
                'trang_thai' => false
            ]);
    }
}
