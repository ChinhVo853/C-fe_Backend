<?php

namespace App\Http\Controllers;

use App\models\NguoiDung;
use App\Services\NguoiDungServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NguoiDungController extends Controller
{
    //
    protected $NguoiDungServices;
    public function __construct(NguoiDungServices $NguoiDungServices)
    {
        $this->NguoiDungServices = $NguoiDungServices;
    }


    public function login(Request $request)
    {

        // Validate the request input
        $validation = validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'không được để trống',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'không được để trống',
        ]);

        // If validation fails, return a 422 response with errors
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        // Get the credentials from the request
        $credentials = $request->only(['email', 'password']);
        // Attempt to authenticate the user with the provided credentials
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the TTL (Time To Live) from the JWT configuration
        $ttl = config('jwt.ttl');

        // Respond with the generated token and its expiration time
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60 // Time-to-live in seconds
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function TaoTaiKhoan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|max:100',
            'soDienThoai' => 'required|string|max:100'
        ], [
            'ten.required' => 'vui lòng nhập tên',
            'ten.string' => 'Tên loại phải là chữ a-z hoặc 0-9',
            'ten.max' => 'nhiều nhất 100 ký tự',
            'email.required' => 'vui lòng nhập email',
            'email.string' => 'Email loại phải là chữ a-z hoặc 0-9',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'nhiều nhất 100 ký tự',
            'password.required' => 'vui lòng nhập mật khẩu',
            'password.string' => 'Mật khẩu phải là chữ a-z hoặc 0-9',
            'password.max' => 'nhiều nhất 100 ký tự',
            'soDienThoai.required' => 'vui lòng nhập số điện thoại',
            'soDienThoai.string' => 'Số điện thoại phải là chữ a-z hoặc 0-9',
            'soDienThoai.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $kiemTraEmail = $this->NguoiDungServices->KiemTraTen($request->email);
        if ($kiemTraEmail->count() > 0) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Đã tồn tại email'
            ], 422);
        }

        $this->NguoiDungServices->TaoTaiKhoan($request->ten, $request->soDienThoai, $request->password, $request->email);
        return response()->json([
            'message' => 'thanh cong'
        ], 200);
    }

    public function XemDanhSachTaiKhoan()
    {
        $data = $this->NguoiDungServices->DanhSachTaiKhoan();
        return response()->json([
            'message' => 'thanh cong',
            'data'    => $data
        ], 200);
    }

    public function XoaTaiKhoan(Request $request)
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

        if ($request->id == 1) {
            return response()->json([
                'status' => 'error',
                'errors' => "không thể xoá tài khoản này"
            ], 422);
        }
        $this->NguoiDungServices->Xoa($request->id);
        return response()->json([
            'message' => 'thanh cong',
        ], 200);
    }

    public function DoiMatKhau(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|max:100',
        ], [
            'email.required' => 'vui lòng nhập email',
            'email.string' => 'Email loại phải là chữ a-z hoặc 0-9',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'nhiều nhất 100 ký tự',
            'password.required' => 'vui lòng nhập mật khẩu',
            'password.string' => 'Mật khẩu phải là chữ a-z hoặc 0-9',
            'password.max' => 'nhiều nhất 100 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $this->NguoiDungServices->MatKhau($request->password, $request->email);

        return response()->json([
            'message' => 'thanh cong',
        ], 200);
    }
}
