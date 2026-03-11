<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        if ($request->nik == '12345' && $request->password == 'password') {
            session([
                'is_logged_in' => true,
                'user_name' => 'Sekar Sekar',
                'user_nik' => '12345',
                'user_jabatan' => 'Staff IT',
                'user_unit' => 'Teknologi Informasi',
                'user_role' => 'Karyawan',
            ]);

            return redirect('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->with('error', 'NIK atau Password salah.')->withInput();
    }

    public function profile()
    {
        return view('pages.profil');
    }

    public function logout()
    {
        session()->forget(['is_logged_in', 'user_name', 'user_nik', 'user_jabatan', 'user_unit', 'user_role']);

        return redirect('/login');
    }
}
