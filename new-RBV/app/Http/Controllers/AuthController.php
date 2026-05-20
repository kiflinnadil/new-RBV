<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('NIK', $request->nik)->first();

        if (! $user) {
            return back()->with('error', 'NIK tidak ditemukan');
        }

        if (! Auth::attempt([
            'NIK' => $request->nik,
            'password' => $request->password,
        ])) {
            return back()->with('error', 'Password salah');
        }
        Kunjungan::create([
            'id_user' => Auth::id(),
            'halaman' => 'login',
        ]);

        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
