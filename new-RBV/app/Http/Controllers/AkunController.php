<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('pages.tambah-akun', compact('users'));
    }

    public function create()
    {
        return view('pages.tambah-akun');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|unique:users,NIK',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'role' => 'required|in:admin,sekretaris,karyawan',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'NIK' => $request->NIK,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'role' => $request->role,
            'password' => $request->password
        ]);

        return redirect()->route('akun.index')
            ->with('success','Akun berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.Akun.editakun', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'role' => $request->role
        ]);

        return redirect()->route('akun.index')
            ->with('success','Akun berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('akun.index')
            ->with('success','Akun berhasil dihapus');
    }
}