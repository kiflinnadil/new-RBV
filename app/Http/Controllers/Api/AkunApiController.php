<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AkunApiController extends Controller
{
    public function index()
    {
        return response()->json(User::latest()->get());
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
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

        $user = User::create([
            'NIK' => $request->NIK,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'role' => $request->role,
            'password' => $request->password
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}