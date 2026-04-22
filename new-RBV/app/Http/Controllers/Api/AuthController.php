<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'NIK' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('NIK', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Login gagal'
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::guard('api')->user()
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}