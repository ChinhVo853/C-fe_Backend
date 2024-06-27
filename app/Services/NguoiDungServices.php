<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungServices
{
    public function TaoTaiKhoan(string $ten, string $soDienThoai, string $password, string $email)
    {
        DB::table('nguoi_dung')
            ->insert([
                'ho_ten' => $ten,
                'so_dien_thoai' => $soDienThoai,
                'email' => $email,
                'password' =>  Hash::make($password),
                'quyen_id' => 2
            ]);
    }

    public function KiemTraTen(string $email)
    {
        $data = DB::table('nguoi_dung')
            ->select('email')
            ->where('email', '=', $email)
            ->get();
        return $data;
    }

    public function DanhSachTaiKhoan()
    {
        $data = DB::table('nguoi_dung as nd')
            ->select(
                'nd.id',
                'nd.ho_ten',
                'nd.so_dien_thoai',
                'email',
                'q.ten as ten_quyen'
            )->join('quyen as q', 'nd.quyen_id', '=', 'q.id')->get();
        return $data;
    }

    public function Xoa(int $id)
    {
        DB::table('nguoi_dung')->where('id', '=', $id)->delete();
    }

    public function MatKhau(string $password, string $email)
    {
        DB::table('nguoi_dung')
            ->where('email', '=', $email)
            ->update(['password' => Hash::make($password)]);
    }
}
