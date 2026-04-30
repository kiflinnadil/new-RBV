<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;

// class AkunController extends Controller
// {
//     public function index()
//     {
//         $users = User::latest()->get();
//         return view('pages.tambah-akun', compact('users'));
//     }

//     public function create()
//     {
//         return view('pages.tambah-akun');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'NIK' => 'required|unique:users,NIK',
//             'nama_lengkap' => 'required',
//             'jabatan' => 'required',
//             'unit_kerja' => 'required',
//             'role' => 'required|in:admin,sekretaris,karyawan',
//             'password' => 'required|confirmed|min:6'
//         ]);

//         User::create([
//             'NIK' => $request->NIK,
//             'nama_lengkap' => $request->nama_lengkap,
//             'jabatan' => $request->jabatan,
//             'unit_kerja' => $request->unit_kerja,
//             'role' => $request->role,
//             'password' => $request->password
//         ]);

//         return redirect()->route('akun.index')
//             ->with('success','Akun berhasil ditambahkan');
//     }

//     public function edit($id)
//     {
//         $user = User::findOrFail($id);
//         return view('pages.Akun.editakun', compact('user'));
//     }

//     public function update(Request $request, $id)
//     {
//         $user = User::findOrFail($id);

//         $user->update([
//             'nama_lengkap' => $request->nama_lengkap,
//             'jabatan' => $request->jabatan,
//             'unit_kerja' => $request->unit_kerja,
//             'role' => $request->role
//         ]);

//         return redirect()->route('akun.index')
//             ->with('success','Akun berhasil diupdate');
//     }

//     public function destroy($id)
//     {
//         User::findOrFail($id)->delete();

//         return redirect()->route('akun.index')
//             ->with('success','Akun berhasil dihapus');
//     }
// }

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('NIK', 'like', "%{$q}%")
                    ->orWhere('unit_kerja', 'like', "%{$q}%")
                    ->orWhere('jabatan', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('pages.KelolahAkun.kelolah_akun', compact('users'));
    }

    public function create()
    {
        return view('pages.KelolahAkun.tambah_akun');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|unique:users,NIK',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'role' => 'required|in:super_admin,admin,sekretaris,karyawan,unit',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'NIK' => $request->NIK,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('pages.KelolahAkun.edit_akun', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'role' => 'required|in:super_admin,admin,sekretaris,karyawan,unit',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil diupdate.');
    }

    public function destroy($id)
    {
        if ($id == Auth::user()->id_user) {
            return redirect()->route('akun.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    public function resetAllPassword(Request $request)
    {
        $request->validate([
            'password_baru' => 'required|min:6',
        ]);

        User::where('id_user', '!=', Auth::user()->id_user)
            ->update(['password' => Hash::make($request->password_baru)]);

        return redirect()->route('akun.index')
            ->with('success', 'Password seluruh akun berhasil direset.');
    }
}
