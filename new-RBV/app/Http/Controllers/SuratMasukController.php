<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Persetujuan;
use App\Models\TrackingSurat;
use App\Models\SuratTag;
use App\Models\Notifikasi;
use App\Models\UnitKerja;

class SuratMasukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = SuratMasuk::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        if ($user->role == 'unit' || $user->role == 'karyawan') {

            $query->where('dibuat_oleh', $user->id_user);

        } elseif ($user->id_jabatan == 1) {

            // Direktur
            $query->whereHas('persetujuans', function ($q) use ($user) {

                $q->where('user_id', $user->id_user);

            });

        } elseif ($user->id_jabatan == 2) {

            // Kepala Bagian
            $query->whereHas('persetujuans', function ($q) use ($user) {

                $q->where('user_id', $user->id_user);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('nomor_agenda', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PRIORITAS
        |--------------------------------------------------------------------------
        */

        if ($request->prioritas) {

            $query->where('prioritas', $request->prioritas);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {

            $query->where('status', $request->status);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER UNIT
        |--------------------------------------------------------------------------
        */

        if ($request->unit) {

            $query->whereHas('pembuat', function ($q) use ($request) {

                $q->where('unit_kerja', $request->unit);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | DATA SURAT
        |--------------------------------------------------------------------------
        */

        $suratMasuk = $query
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | DATA KATEGORI UNIT
        |--------------------------------------------------------------------------
        */

        $kategoriList = UnitKerja::all()
            ->groupBy('kabid')
            ->map(function ($items) {

                return $items->pluck('nama_unit')->unique()->values();

            });

        /*
        |--------------------------------------------------------------------------
        | SURAT MENUNGGU
        |--------------------------------------------------------------------------
        */

        $suratMenunggu = SuratMasuk::where(
            'status',
            'menunggu_sekretaris'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk',
            compact(
                'suratMasuk',
                'kategoriList',
                'suratMenunggu'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $usersTag = User::whereIn('id_jabatan', [1, 2])->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_create',
            compact('usersTag')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nomor_agenda' => 'required',
            'nomor_surat' => 'nullable',
            'tanggal_surat' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'asal_surat' => 'required',
            'jenis' => 'required|in:internal,external',
            'perihal' => 'required',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI JENIS SURAT
        |--------------------------------------------------------------------------
        */

        // Kepala Unit / Karyawan hanya boleh internal
        if (
            in_array($user->role, ['unit', 'karyawan']) &&
            $request->jenis == 'external'
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'jenis' => 'Kepala unit/karyawan hanya dapat membuat surat internal.'
                ]);

        }

        $file = null;

        if ($request->hasFile('file_scan')) {

            $file = $request->file('file_scan')
                ->store('surat-masuk', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | STATUS AWAL
        |--------------------------------------------------------------------------
        */

        $status = 'menunggu_sekretaris';

        // Jika sekretaris membuat surat external
        // langsung ke direktur
        if (
            $user->id_jabatan == 4 &&
            $request->jenis == 'external'
        ) {

            $status = 'menunggu_direktur';

        }

        /*
        |--------------------------------------------------------------------------
        | CREATE SURAT
        |--------------------------------------------------------------------------
        */

        $surat = SuratMasuk::create([
            'nomor_agenda' => $request->nomor_agenda,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'asal_surat' => $request->asal_surat,
            'jenis' => $request->jenis,
            'perihal' => $request->perihal,
            'file_scan' => $file,
            'status' => $status,
            'dibuat_oleh' => $user->id_user,
        ]);

        /*
        |--------------------------------------------------------------------------
        | TRACKING
        |--------------------------------------------------------------------------
        */

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat dibuat',
        ]);

        /*
        |--------------------------------------------------------------------------
        | JIKA SURAT INTERNAL
        | KIRIM KE SEKRETARIS
        |--------------------------------------------------------------------------
        */

        if ($status == 'menunggu_sekretaris') {

            $sekretaris = User::where('id_jabatan', 4)
                ->pluck('id_user')
                ->toArray();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Masuk Baru',
                'Ada surat baru menunggu proses sekretaris',
                '/eoffice/surat-masuk/' . $surat->id,
                'info'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SURAT EXTERNAL DARI SEKRETARIS
        | LANGSUNG KE DIREKTUR & KABAG
        |--------------------------------------------------------------------------
        */

        if ($status == 'menunggu_direktur') {

            /*
            |--------------------------------------------------------------------------
            | TAG DIREKTUR & KABAG
            |--------------------------------------------------------------------------
            */

            foreach ($request->tag_users ?? [] as $userId) {

                SuratTag::create([
                    'surat_id' => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id' => $userId,
                ]);

                $tagUser = User::find($userId);

                if ($tagUser && $tagUser->id_jabatan == 1) {

                    Persetujuan::create([
                        'surat_id' => $surat->id,
                        'surat_type' => SuratMasuk::class,
                        'user_id' => $userId,
                        'role_approver' => 'direktur',
                        'status' => 'menunggu',
                    ]);

                }

                if ($tagUser && $tagUser->id_jabatan == 2) {

                    Persetujuan::create([
                        'surat_id' => $surat->id,
                        'surat_type' => SuratMasuk::class,
                        'user_id' => $userId,
                        'role_approver' => 'kabag',
                        'status' => 'menunggu',
                    ]);

                }

            }

            /*
            |--------------------------------------------------------------------------
            | NOTIF DIREKTUR & KABAG
            |--------------------------------------------------------------------------
            */

            $penerima = User::whereIn('id_jabatan', [1, 2])
                ->pluck('id_user')
                ->toArray();

            Notifikasi::kirimKe(
                $penerima,
                'Surat Menunggu Persetujuan',
                'Ada surat baru menunggu approval',
                '/eoffice/surat-masuk/' . $surat->id,
                'warning'
            );

        }

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil dikirim.');
    }
}