<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('size')
            ->insert(['ten' => 'Mặc định']);
        DB::table('size')
            ->insert(['ten' => 'X']);
        DB::table('size')
            ->insert(['ten' => 'M']);
        DB::table('size')
            ->insert(['ten' => 'L']);
    }
}
