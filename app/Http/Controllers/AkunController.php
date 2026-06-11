<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with([
            'roleRelation',
            'unitKerjaRelation',
            'jabatanRelation'
        ])->latest();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('NIK', 'like', "%{$search}%")

                    ->orWhereHas('jabatanRelation', function ($jabatan) use ($search) {

                        $jabatan->where('nama_jabatan', 'like', "%{$search}%");
                    })

                    ->orWhereHas('unitKerjaRelation', function ($unit) use ($search) {

                        $unit->where('nama_unit', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('role')) {

            $query->whereHas('roleRelation', function ($q) use ($request) {

                $q->where('nama_role', $request->role);
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('pages.KelolahAkun.kelolah_akun', compact('users'));
    }

    public function create()
    {
        $units = UnitKerja::orderBy('nama_unit')->get();

        $roles = Role::orderBy('nama_role')->get();

        $jabatans = Jabatan::orderBy('nama_jabatan')->get();

        return view(
            'pages.KelolahAkun.tambah_akun',
            compact('units', 'roles', 'jabatans')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|unique:users,NIK',
            'nama_lengkap' => 'required',

            'id_jabatan' => 'required|exists:jabatans,id_jabatan',

            'id_role' => 'required|exists:roles,id_role',

            'id_unit_kerja' => 'required|exists:unit_kerjas,id_unit_kerja',

            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'NIK' => $request->NIK,

            'nama_lengkap' => $request->nama_lengkap,

            'id_jabatan' => $request->id_jabatan,

            'id_role' => $request->id_role,

            'id_unit_kerja' => $request->id_unit_kerja,

            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();

        $roles = Role::orderBy('nama_role')->get();

        $jabatans = Jabatan::orderBy('nama_jabatan')->get();

        return view(
            'pages.KelolahAkun.edit_akun',
            compact(
                'user',
                'unitKerjas',
                'roles',
                'jabatans'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'NIK' => 'required|unique:users,NIK,' . $id . ',id_user',

            'nama_lengkap' => 'required',

            'id_jabatan' => 'required|exists:jabatans,id_jabatan',

            'id_role' => 'required|exists:roles,id_role',

            'id_unit_kerja' => 'required|exists:unit_kerjas,id_unit_kerja',

            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [

            'NIK' => $request->NIK,

            'nama_lengkap' => $request->nama_lengkap,

            'id_jabatan' => $request->id_jabatan,

            'id_role' => $request->id_role,

            'id_unit_kerja' => $request->id_unit_kerja,
        ];

        if ($request->filled('password')) {

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil diupdate.');
    }

    public function destroy($id)
    {
        if ($id == Auth::user()->id_user) {

            return redirect()
                ->route('akun.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        User::findOrFail($id)->delete();

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    public function resetAllPassword(Request $request)
    {
        $request->validate([
            'password_baru' => 'required|min:6',
        ]);

        User::where('id_user', '!=', Auth::user()->id_user)
            ->update([
                'password' => Hash::make($request->password_baru)
            ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Password seluruh akun berhasil direset.');
    }
}