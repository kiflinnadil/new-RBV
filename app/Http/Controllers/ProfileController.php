<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = (object) [
            'name' => 'Dimas Anggara',
            'nik' => '12345678',
            'jabatan' => 'Staff Administrasi',
            'unit_kerja' => 'Rekam Medis',
            'role' => 'Karyawan',
            'password' => '12345678',
        ];

        return view('pages.profil', compact('user'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('logged_in');

        return redirect('/login');
    }

    public function show()
    {

        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }
}
