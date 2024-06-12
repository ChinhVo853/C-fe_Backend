<?php

namespace App\Http\Controllers;

use App\Services\SanPhamServices;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    protected $sanPhamServices;
    public function __construct(sanPhamServices $sanPhamServices)
    {
        $this->sanPhamServices = $sanPhamServices;
    }

    public function Them(Request $request)
    {

        $mon = $this->sanPhamServices->ThemMon($request->ten, $request->loaiID, $request->gia, $request->sizeID);

        $this->sanPhamServices->ThemChiTietMon($mon, $request->soLuongNguyenLieu, $request->nguyenLieuID);

        return response([
            'message' => "thành công"
        ]);
    }

    public function ThemAnh(Request $request)
    {
        // Lưu hình ảnh vào thư mục public/avatar
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('AnhMonAN'), $imageName);

        $this->sanPhamServices->ThemAnhMon($request->MonID, $imageName);

        // Trả về phản hồi thành công
        return response()->json(['success' => true, 'image_name' => $imageName]);
    }


    public function Xem()
    {
        $data = $this->sanPhamServices->XemMon();
        return response()->json([
            'message' => 'thanh cong',
            'data2' => $data
        ]);
    }
}
