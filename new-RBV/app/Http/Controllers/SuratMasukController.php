<?php

namespace App\Http\Controllers;

use App\Exports\SuratMasukExport;
use App\Models\Notifikasi;
use App\Models\Persetujuan;
use App\Models\SuratMasuk;
use App\Models\SuratTag;
use App\Models\TrackingSurat;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = SuratMasuk::with([
            'pembuat.unitKerjaRelation',
        ]);

        // FILTER BERDASARKAN ROLE

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

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_agenda', 'like', '%'.$request->search.'%')
                    ->orWhere('nomor_surat', 'like', '%'.$request->search.'%')
                    ->orWhere('perihal', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->unit) {
            $query->whereHas('pembuat', function ($q) use ($request) {
                $q->where('unit_kerja', $request->unit);
            });

        }

        // DATA SURAT

        $suratMasuk = $query
            ->latest()
            ->paginate(10);

        //  DATA KATEGORI UNIT

        $kategoriList = UnitKerja::all()
            ->groupBy('kabid')
            ->map(function ($items) {
                return $items->pluck('nama_unit')->unique()->values();
            });

        $suratMenunggu = SuratMasuk::where(
            'status',
            'menunggu_sekretaris'
        )->count();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk',
            compact(
                'suratMasuk',
                'kategoriList',
                'suratMenunggu'
            )
        );
    }

    public function create()
    {
        $usersTag = User::whereIn('id_jabatan', [1, 2])->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_create',
            compact('usersTag')
        );
    }

    public function edit($id)
    {
        $user = Auth::user();

        $surat = SuratMasuk::findOrFail($id);

        // Hanya sekretaris & status menunggu sekretaris
        if (
            $user->id_jabatan != 4 ||
            $surat->status != 'menunggu_sekretaris'
        ) {
            return redirect()
                ->route('eoffice.surat-masuk.show', $id);
        }

        // Tandai notif edit dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/'.$id.'/edit')
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
            ]);

        $usersTag = User::whereIn('id_jabatan', [1, 2])->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_edit',
            compact(
                'surat',
                'usersTag'
            )
        );
    }

    public function show($id)
    {
        $user = Auth::user();

        // Tandai notif detail sebagai dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where(function ($q) use ($id) {
                $q->where('url', '/eoffice/surat-masuk/'.$id)
                    ->orWhere('url', '/eoffice/surat-masuk/'.$id.'#approval');
            })

            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
            ]);

        $surat = SuratMasuk::with([
            'pembuat',
            'tags.user',
            'persetujuans.user',
            'tracking.user',
        ])->findOrFail($id);

        $bisaApprove = false;
        $jabatanApproval = null;

        // DIREKTUR
        if (
            $user->id_jabatan == 1 &&
            $surat->status == 'menunggu_direktur'
        ) {
            $bisaApprove = true;
            $jabatanApproval = 'direktur';
        }

        // KABAG
        if (
            $user->id_jabatan == 2 &&
            in_array($surat->status, [
                'menunggu_kabag',
                'pending',
            ]) &&

            $surat->persetujuans()
                ->where('user_id', $user->id_user)
                ->exists()

        ) {
            $bisaApprove = true;
            $jabatanApproval = 'kabag';
        }

        $unitsTerkait = User::where('id_jabatan', 3)->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_show',
            compact(
                'surat',
                'bisaApprove',
                'jabatanApproval',
                'unitsTerkait'
            )
        );
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nomor_agenda' => 'nullable',
            'nomor_surat' => 'nullable',
            'tanggal_surat' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'asal_surat' => 'required',
            'prioritas' => 'nullable|in:biasa,sedang,segera',
            'jenis' => 'required|in:internal,external',
            'perihal' => 'nulable|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // VALIDASI JENIS SURAT

        if (
            in_array($user->role, ['unit', 'karyawan']) &&
            $request->jenis == 'external'
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'jenis' => 'Karyawan/unit hanya dapat membuat surat internal.',
                ]);
        }

        // UPLOAD FILE

        $file = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan')
                ->store('surat-masuk', 'public');
        }

        // STATUS AWAL

        $status = 'menunggu_sekretaris';
        if ($user->id_jabatan == 4) {
            $tagUsers = User::whereIn(
                'id_user',
                $request->tag_users ?? []

            )->get();
            $adaDirektur = $tagUsers->contains('id_jabatan', 1);
            $adaKabag = $tagUsers->contains('id_jabatan', 2);
            if ($adaDirektur) {
                $status = 'menunggu_direktur';
            } elseif ($adaKabag) {
                $status = 'menunggu_kabag';
            }

        }

        $nomorAgenda = $request->nomor_agenda;
        if (in_array($user->role, ['unit', 'karyawan'])) {
            $nomorAgenda = null;
        }

        $surat = SuratMasuk::create([
            'nomor_agenda' => $nomorAgenda,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'asal_surat' => $request->asal_surat,
            'jenis' => $request->jenis,
            'perihal' => $request->perihal,
            'prioritas' => $request->prioritas,
            'file_scan' => $file,
            'status' => $status,
            'dibuat_oleh' => $user->id_user,
        ]);

        // TRACKING

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat dibuat',
        ]);

        //  INTERNAL -> KE SEKRETARIS

        if ($status == 'menunggu_sekretaris') {

            $sekretaris = User::where('id_jabatan', 4)
                ->pluck('id_user')
                ->toArray();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Masuk Baru',
                'Ada surat baru menunggu proses sekretaris',
                '/eoffice/surat-masuk/'.$surat->id.'/edit',
                'info'
            );
        }

        //  EXTERNAL SEKRETARIS -> DIREKTUR/KABAG

        if (in_array($status, ['menunggu_direktur', 'menunggu_kabag'])) {
            foreach ($request->tag_users ?? [] as $userId) {
                SuratTag::create([
                    'surat_id' => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id' => $userId,
                ]);
                $tagUser = User::find($userId);

                // DIREKTUR

                if ($tagUser && $tagUser->id_jabatan == 1) {
                    Persetujuan::create([
                        'surat_id' => $surat->id,
                        'surat_type' => SuratMasuk::class,
                        'user_id' => $userId,
                        'role_approver' => 'direktur',
                        'status' => 'menunggu',
                    ]);
                }

                // KABAG

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

            $penerima = $request->tag_users ?? [];

            Notifikasi::kirimKe(
                $penerima,
                'Surat Menunggu Persetujuan',
                'Ada surat baru menunggu approval',
                '/eoffice/surat-masuk/'.$surat->id,
                'peringatan'
            );
        }

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SURAT OLEH SEKRETARIS
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'prioritas' => 'required|in:biasa,sedang,segera',
            'nomor_agenda' => 'required|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $status = 'menunggu_direktur';
        $tagUsers = User::whereIn('id_user', $request->tag_users ?? [])->get();
        $adaDirektur = $tagUsers->contains('id_jabatan', 1);
        $adaKabag = $tagUsers->contains('id_jabatan', 2);

        // LOGIC STATUS

        if ($adaDirektur && $adaKabag) {
            $status = 'menunggu_direktur';
        } elseif ($adaDirektur) {
            $status = 'menunggu_direktur';
        } elseif ($adaKabag) {
            $status = 'menunggu_kabag';
        }

        $surat->update([
            'nomor_agenda' => $request->nomor_agenda,
            'status' => $status,
            'prioritas' => $request->prioritas,
            'catatan' => $request->catatan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIF SEKRETARIS SUDAH DIBACA
        |--------------------------------------------------------------------------
        */

        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/'.$surat->id.'/edit')
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
            ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS TAG & PERSETUJUAN LAMA
        |--------------------------------------------------------------------------
        */

        SuratTag::where('surat_id', $surat->id)->delete();
        Persetujuan::where('surat_id', $surat->id)->delete();

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

            /*

            |--------------------------------------------------------------------------

            | DIREKTUR

            |--------------------------------------------------------------------------

            */

            if ($tagUser && $tagUser->id_jabatan == 1) {
                Persetujuan::create([
                    'surat_id' => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id' => $userId,
                    'role_approver' => 'direktur',
                    'status' => 'menunggu',
                ]);

                Notifikasi::where('id_user', $userId)
                    ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                    ->delete();

                Notifikasi::kirim(
                    $userId,
                    'Surat Menunggu Persetujuan',
                    'Ada surat baru menunggu approval direktur.',
                    '/eoffice/surat-masuk/'.$surat->id,
                    'peringatan'
                );
            }

            /*

            |--------------------------------------------------------------------------

            | KABAG

            |--------------------------------------------------------------------------

            */

            if ($tagUser && $tagUser->id_jabatan == 2) {

                Persetujuan::create([
                    'surat_id' => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id' => $userId,
                    'role_approver' => 'kabag',
                    'status' => 'menunggu',

                ]);

                // HAPUS NOTIF LAMA

                Notifikasi::where('id_user', $userId)

                    ->where(function ($q) use ($surat) {
                        $q->where('url', '/eoffice/surat-masuk/'.$surat->id)
                            ->orWhere('url', '/eoffice/surat-masuk/'.$surat->id.'#approval');

                    })

                    ->delete();

                // KIRIM NOTIF KABAG

                Notifikasi::kirim(

                    $userId,
                    'Surat Menunggu Persetujuan Kabag',
                    'Ada surat baru menunggu approval kabag.',
                    '/eoffice/surat-masuk/'.$surat->id.'#approval',
                    'peringatan'

                );

            }
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS NOTIF LAMA PENGIRIM
        |--------------------------------------------------------------------------
        */

        Notifikasi::where('id_user', $surat->dibuat_oleh)
            ->where('url', '/eoffice/surat-masuk/'.$surat->id)
            ->where('judul', 'Surat Diproses Sekretaris')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | NOTIF KE KEPALA UNIT / PENGIRIM
        |--------------------------------------------------------------------------
        */

        $pesanPengirim = 'Surat diproses sekretaris.';
        if ($adaDirektur && $adaKabag) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke direktur serta kabag.';
        } elseif ($adaDirektur) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke direktur.';
        } elseif ($adaKabag) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke kabag.';
        }

        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Diproses Sekretaris',
            $pesanPengirim,
            '/eoffice/surat-masuk/'.$surat->id,
            'info'
        );

        /*
        |--------------------------------------------------------------------------
        | TRACKING
        |--------------------------------------------------------------------------
        */

        $aksiTracking = 'Surat diteruskan';
        if ($adaDirektur && $adaKabag) {
            $aksiTracking = 'Surat diteruskan ke direktur dan kabag';
        } elseif ($adaDirektur) {
            $aksiTracking = 'Surat diteruskan ke direktur';
        } elseif ($adaKabag) {
            $aksiTracking = 'Surat diteruskan ke kabag';
        }

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => $aksiTracking,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with(
                'success',
                'Surat berhasil diteruskan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SETUJUI SURAT
    |--------------------------------------------------------------------------
    */

    public function setujui(Request $request, $id)
    {
        $user = Auth::user();

        $surat = SuratMasuk::findOrFail($id);

        $persetujuan = Persetujuan::where([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
        ])->first();

        if (! $persetujuan) {

            return back()->with(
                'error',
                'Anda tidak memiliki akses approval.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE APPROVAL
        |--------------------------------------------------------------------------
        */

        $persetujuan->update([
            'status' => 'disetujui',
            'catatan' => $request->catatan,
            'approved_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIF USER APPROVAL SUDAH DIBACA
        |--------------------------------------------------------------------------
        */

        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/'.$surat->id)
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
            ]);

        /*
        |--------------------------------------------------------------------------
        | DIREKTUR MENYETUJUI
        |--------------------------------------------------------------------------
        */

        if ($user->id_jabatan == 1) {
            $adaKabag = Persetujuan::where([
                'surat_id' => $surat->id,
                'surat_type' => SuratMasuk::class,
                'role_approver' => 'kabag',
            ])->exists();

            $surat->update([
                'status' => $adaKabag
                    ? 'menunggu_kabag'
                    : 'disetujui',

            ]);

            // HAPUS TAG UNIT LAMA
            SuratTag::where([
                'surat_id' => $surat->id,
                'surat_type' => SuratMasuk::class,
            ])->whereHas('user', function ($q) {
                $q->where('id_jabatan', 3);
            })->delete();

            // TAG UNIT TERKAIT DARI DIREKTUR
            foreach ($request->tag_units ?? [] as $unitId) {

                SuratTag::create([
                    'surat_id' => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id' => $unitId,
                ]);

                // KIRIM NOTIF KE UNIT
                Notifikasi::kirim(
                    $unitId,
                    'Surat Ditugaskan Direktur',
                    'Ada surat yang ditugaskan direktur untuk unit Anda.',
                    '/eoffice/surat-masuk/'.$surat->id,
                    'info'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | HAPUS NOTIF LAMA PENGIRIM
            |--------------------------------------------------------------------------
            */

            Notifikasi::where('id_user', $surat->dibuat_oleh)
                ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                ->where('judul', 'Surat Disetujui Direktur')
                ->delete();

            // HAPUS SEMUA NOTIF LAMA PEMBUAT SURAT

            Notifikasi::where('id_user', $surat->dibuat_oleh)
                ->where(function ($q) use ($surat) {
                    $q->where('url', '/eoffice/surat-masuk/'.$surat->id)
                        ->orWhere('url', '/eoffice/surat-masuk/'.$surat->id.'/edit');
                })
                ->delete();
            /*
            |--------------------------------------------------------------------------
            | NOTIF KE PENGIRIM
            |--------------------------------------------------------------------------
            */

            Notifikasi::kirim(
                $surat->dibuat_oleh,
                'Surat Disetujui Direktur',
                'Surat yang kamu kirim telah disetujui direktur.',
                '/eoffice/surat-masuk/'.$surat->id,
                'sukses'
            );

            /*
            |--------------------------------------------------------------------------
            | NOTIF KABAG
            |--------------------------------------------------------------------------
            */

            $kabagIds = Persetujuan::where([
                'surat_id' => $surat->id,
                'surat_type' => SuratMasuk::class,
                'role_approver' => 'kabag',
            ])->pluck('user_id')->toArray();

            if (! empty($kabagIds)) {
                Notifikasi::whereIn('id_user', $kabagIds)
                    ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                    ->delete();

                Notifikasi::kirimKe(
                    $kabagIds,
                    'Surat Menunggu Persetujuan Kabag',
                    'Ada surat menunggu approval kabag.',
                    '/eoffice/surat-masuk/'.$surat->id.'#approval',
                    'info'

                );

            }
            $sekretaris = User::where('id_jabatan', 4)
                ->pluck('id_user')
                ->toArray();

            Notifikasi::whereIn('id_user', $sekretaris)
                ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                ->delete();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Disetujui Direktur',
                $adaKabag
                    ? 'Surat telah disetujui direktur dan diteruskan ke kabag.'
                    : 'Surat telah disetujui direktur dan selesai.',
                '/eoffice/surat-masuk/'.$surat->id,
                'sukses'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | KABAG MENYETUJUI
        |--------------------------------------------------------------------------
        */

        if ($user->id_jabatan == 2) {

            $surat->update([
                'status' => 'disetujui',
            ]);

            /*
            |--------------------------------------------------------------------------
            | NOTIF KABAG SUDAH DIBACA
            |--------------------------------------------------------------------------
            */

            Notifikasi::where('id_user', $user->id_user)
                ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                ->where('dibaca', false)
                ->update([
                    'dibaca' => true,
                ]);

            /*
            |--------------------------------------------------------------------------
            | HAPUS NOTIF LAMA PENGIRIM
            |--------------------------------------------------------------------------
            */

            Notifikasi::where('id_user', $surat->dibuat_oleh)
                ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                ->where('judul', 'Surat Disetujui Kabag')
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | NOTIF KE PENGIRIM
            |--------------------------------------------------------------------------
            */

            Notifikasi::kirim(
                $surat->dibuat_oleh,
                'Surat Disetujui Kabag',
                'Surat yang kamu kirim telah disetujui kabag.',
                '/eoffice/surat-masuk/'.$surat->id,
                'sukses'
            );

            $sekretaris = User::where('id_jabatan', 4)
                ->pluck('id_user')
                ->toArray();

            // HAPUS NOTIF LAMA SEKRETARIS

            Notifikasi::whereIn('id_user', $sekretaris)
                ->where('url', '/eoffice/surat-masuk/'.$surat->id)
                ->delete();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Disetujui Kabag',
                'Surat telah disetujui kabag.',
                '/eoffice/surat-masuk/'.$surat->id,
                'sukses'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | TRACKING
        |--------------------------------------------------------------------------
        */

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat disetujui',
            'keterangan' => $request->catatan,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.show', $surat->id)
            ->with(
                'success',
                'Surat berhasil disetujui.'
            );
    }

    public function pending(Request $request, $id)
    {
        $user = Auth::user();
        $surat = SuratMasuk::findOrFail($id);

        // HANYA KABAG

        if ($user->id_jabatan != 2) {
            abort(403);
        }

        // UPDATE STATUS

        $surat->update([
            'status' => 'pending',
            'catatan' => $request->catatan,
        ]);

        // UPDATE PERSETUJUAN

        $persetujuan = Persetujuan::where([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
        ])->first();

        if ($persetujuan) {

            $persetujuan->update([
                'status' => 'pending',
                'catatan' => $request->catatan,
            ]);

        }

        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/'.$surat->id)
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
            ]);

        // NOTIF KE PEMBUAT SURAT

        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Dipending',
            'Surat dipending oleh Kabag. Catatan: '.$request->catatan,
            '/eoffice/surat-masuk/'.$surat->id,
            'peringatan'
        );
        $sekretaris = User::where('id_jabatan', 4)

            ->pluck('id_user')

            ->toArray();

        Notifikasi::kirimKe(
            $sekretaris,
            'Surat Dipending',
            'Surat dipending oleh kabag.',
            '/eoffice/surat-masuk/'.$surat->id,
            'peringatan'
        );

        //  TRACKING

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat dipending',
            'keterangan' => $request->catatan,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.show', $surat->id)
            ->with('success', 'Surat berhasil dipending.');
    }

    public function exportExcel()
    {
        return Excel::download(
            new SuratMasukExport,
            'surat-masuk.xlsx'
        );
    }
}
