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


            if ($request->sizeDuyNhat) {
                $timMon = $this->sanPhamServices->TimMon($request->foodName, 1, $request->foodCategory);

                if (isset($timMon)) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => "Món ăn đã tồn tại"
                    ], 422);
                }

                $mon = $this->sanPhamServices->ThemMon(
                    $request->foodName,
                    $request->foodCategory,
                    $request->foodPrice[$i],
                    1,
                    $request->foodStatus
                );
            } else {
                $timMon = $this->sanPhamServices->TimMon($request->foodName, $request->foodSize[$i], $request->foodCategory);

                if ($timMon->count() > 1) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => "Món ăn đã tồn tại"
                    ], 422);
                }

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
        $timMon = $this->sanPhamServices->TimMon($request->tenMon, $request->sizeID, $request->loaiID);

        if ($timMon->count() > 1) {
            return response()->json([
                'status' => 'error',
                'errors' => "Món ăn đã tồn tại"
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

    public function CapNhatTrangThai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'trangThai' => 'required|integer',

        ], [
            'id.required' => 'Không tìm thấy id loại',
            'id.integer' => 'Tên loại phải là số 0-9',
            'trangThai.required' => 'Không tìm thấy id loại',
            'trangThai.integer' => 'Tên loại phải là số 0-9',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        $this->sanPhamServices->SuaTrangThai($request->id, $request->trangThai);
        return response()->json([
            'message' => 'thanh cong',
        ]);
    }


    public function Xoa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'id.required' => 'Không tìm thấy id loại',
            'id.integer' => 'Tên loại phải là số 0-9',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        if ($this->sanPhamServices->XoaMon($request->id) == 0) {
            return response()->json([
                'status' => 'error',
                'errors' =>  'không tìm thấy loại'
            ], 422);
        }
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }

    public function TimMon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tim' => 'required',
        ], [
            'tim.required' => 'Vui lòng nhập món muốn tìm',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $data = $this->sanPhamServices->Tim($request->tim);
        return response()->json([
            'message' => 'thanh cong',
            'data' => $data
        ], 200);
    }
}
