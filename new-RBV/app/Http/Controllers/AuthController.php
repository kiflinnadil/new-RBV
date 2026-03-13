<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('NIK', $request->nik)->first();

        if (!$user) {
            return back()->with('error', 'NIK tidak ditemukan');
        }

        if (!Auth::attempt([
            'NIK' => $request->nik,
            'password' => $request->password
        ])) {
            return back()->with('error', 'Password salah');
        }

        $request->session()->regenerate();

        return redirect('/');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}