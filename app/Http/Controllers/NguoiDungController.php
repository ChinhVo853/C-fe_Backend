<?php

namespace App\Http\Controllers;

use App\models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NguoiDungController extends Controller
{
    //
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
}
