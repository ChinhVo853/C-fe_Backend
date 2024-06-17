<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quyen')
            ->insert(['ten' => 'Quản lý']);
        DB::table('quyen')
            ->insert(['ten' => 'NBhân viên']);
    }
}
