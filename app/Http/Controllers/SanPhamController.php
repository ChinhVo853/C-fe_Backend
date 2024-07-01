<?php

namespace App\Http\Controllers;

use App\Services\SanPhamServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller
{
    protected $sanPhamServices;
    public function __construct(sanPhamServices $sanPhamServices)
    {
        $this->sanPhamServices = $sanPhamServices;
    }

    public function Them(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foodName' => 'required|string|max:255',
            'foodCategory' => 'required',
            'foodPrice' => 'required|array',
            'foodSize' => 'array',
            'foodStatus' => 'required'
        ], [
            'foodName.required' => 'vui lòng nhập tên',
            'foodName.string' => 'Tên món phải là chữ a-z hoặc 0-9',
            'foodName.max' => 'nhiều nhất 255 ký tự',
            'foodCategory.required' => 'vui lòng chọn loại',
            'foodPrice.required' => 'vui lòng nhập giá',
            'foodPrice.array' => 'Đây phải là 1 mảng',
            'foodSize.array' => 'Đây phải là 1 mảng',
            'foodStatus.required' => 'Vui lòng chọn trạng thái',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        for ($i = 0; $i < count($request->foodPrice); $i++) {
            if (!isset($request->foodPrice[$i])) {
                return response()->json([
                    'status' => 'error',
                    'errors' => "Vui lòng nhập giá"
                ], 422);
            }
            $timMon = $this->sanPhamServices->TimMon($request->foodName, $request->foodSize[$i], $request->foodCategory);

            if (isset($timMon)) {
                return response()->json([
                    'status' => 'error',
                    'errors' => "Món ăn đã tồn tại"
                ], 422);
            }

            if ($request->sizeDuyNhat) {
                $mon = $this->sanPhamServices->ThemMon(
                    $request->foodName,
                    $request->foodCategory,
                    $request->foodPrice[$i],
                    1,
                    $request->foodStatus
                );
            } else {
                $mon = $this->sanPhamServices->ThemMon(
                    $request->foodName,
                    $request->foodCategory,
                    $request->foodPrice[$i],
                    $request->foodSize[$i],
                    $request->foodStatus
                );
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Thành công',
        ]);
    }

    public function ThemAnh(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MonID' => 'required',
            'tenMon' => 'required',
            'gia' => 'required',
            'trangThai' => 'required',

        ], [
            'MonID.required' => 'Không được để trống',
            'tenMon.required' => 'Không được để trống',
            'gia.required' => 'Không được để trống',
            'trangThai.required' => 'Không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {

            // Lưu hình ảnh vào thư mục public/avatar
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('AnhMonAN'), $imageName);

            $this->sanPhamServices->ThemAnhMon($request->MonID, $imageName);

            // Trả về phản hồi thành công
        }

        $this->sanPhamServices->SuaMon($request->tenMon, $request->MonID, $request->gia, $request->trangThai);
        return response()->json([
            'status' => 'success',
            'message' => 'Thành công',
        ]);
    }


    public function Xem()
    {
        $data = $this->sanPhamServices->XemMon();
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ]);
    }

    public function XemLoai($id)
    {
        $data = $this->sanPhamServices->TimTungMon($id);
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ]);
    }
}
