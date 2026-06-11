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
                $q->where('nomor_agenda', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        // FILTER BULAN DARI tanggal_surat
        if ($request->bulan) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        // FILTER TAHUN DARI tanggal_surat
        if ($request->tahun) {
            $query->whereYear('tanggal_surat', $request->tahun);
        }

        if ($request->unit) {
            $query->whereHas('pembuat', function ($q) use ($request) {
                $q->whereHas('unitKerjaRelation', function ($q2) use ($request) {
                    $q2->where('nama_unit', $request->unit);
                });
            });
        }

        $suratMasuk = $query
            ->orderBy('nomor_agenda', 'asc')
            ->paginate(10);

        $kategoriList = UnitKerja::all()
            ->groupBy('kabid')
            ->map(function ($items) {
                return $items->pluck('nama_unit')->unique()->values();
            });

        $suratMenunggu = SuratMasuk::where('status', 'menunggu_sekretaris')->count();

        $tahunList = SuratMasuk::selectRaw('YEAR(tanggal_surat) as tahun')
            ->whereNotNull('tanggal_surat')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk',
            compact(
                'suratMasuk',
                'kategoriList',
                'suratMenunggu',
                'tahunList'
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

        $surat = SuratMasuk::with([
            'pembuat',
            'persetujuans.user',
            'tracking.user',
        ])->findOrFail($id);

        if ($user->id_jabatan != 4) {
            return redirect()->route('eoffice.surat-masuk.show', $id);
        }

        // Tandai notif edit dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/' . $id . '/edit')
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        $usersTag = User::whereIn('id_jabatan', [1, 2])->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_edit',
            compact('surat', 'usersTag')
        );
    }

    public function show($id)
    {
        $user = Auth::user();

        // Tandai notif detail sebagai dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where(function ($q) use ($id) {
                $q->where('url', '/eoffice/surat-masuk/' . $id)
                    ->orWhere('url', '/eoffice/surat-masuk/' . $id . '#approval');
            })
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        $surat = SuratMasuk::with([
            'pembuat',
            'tags.user',
            'persetujuans.user',
            'tracking.user',
        ])->findOrFail($id);

        $bisaApprove    = false;
        $jabatanApproval = null;

        // DIREKTUR
        if ($user->id_jabatan == 1 && $surat->status == 'menunggu_direktur') {
            $bisaApprove    = true;
            $jabatanApproval = 'direktur';
        }

        // KABAG
        $persetujuanKabag = $surat->persetujuans()
            ->where('user_id', $user->id_user)
            ->where('role_approver', 'kabag')
            ->first();

        // JIKA DITOLAK TAPI BUKAN OLEH KABAG INI
        if (
            $surat->status == 'ditolak' &&
            $persetujuanKabag &&
            $persetujuanKabag->status != 'ditolak'
        ) {
            $bisaApprove = false;
        }

        // KABAG
        if (
            $user->id_jabatan == 2 &&
            $persetujuanKabag &&
            in_array($surat->status, [
                'menunggu_kabag',
                'pending',
                'ditolak'
            ])
        ) {

            $bisaApprove = true;
            $jabatanApproval = 'kabag';
        }

        $unitsTerkait = User::where('id_jabatan', 3)->get();

        return view(
            'pages.E-Office.SuratMasuk.suratmasuk_show',
            compact('surat', 'bisaApprove', 'jabatanApproval', 'unitsTerkait')
        );
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nomor_agenda'  => 'nullable',
            'nomor_surat'   => 'nullable',
            'tanggal_surat' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'asal_surat'    => 'required',
            'prioritas'     => 'nullable|in:biasa,sedang,segera',
            'jenis'         => 'required|in:internal,external',
            'perihal'       => 'nullable|string',
            'file_scan'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // VALIDASI JENIS SURAT
        if (in_array($user->role, ['unit', 'karyawan']) && $request->jenis == 'external') {
            return back()->withInput()->withErrors([
                'jenis' => 'Karyawan/unit hanya dapat membuat surat internal.',
            ]);
        }

        // UPLOAD FILE
        $file = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan')->store('surat-masuk', 'public');
        }

        // STATUS AWAL
        $status      = 'menunggu_sekretaris';
        $adaDirektur = false;
        $adaKabag    = false;
        $tagUsers    = collect();

        if ($user->id_jabatan == 4) {
            $tagUsers    = User::whereIn('id_user', $request->tag_users ?? [])->get();
            $adaDirektur = $tagUsers->contains('id_jabatan', 1);
            $adaKabag    = $tagUsers->contains('id_jabatan', 2);

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
            'nomor_agenda'  => $nomorAgenda,
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'asal_surat'    => $request->asal_surat,
            'jenis'         => $request->jenis,
            'perihal'       => $request->perihal,
            'prioritas'     => $request->prioritas,
            'file_scan'     => $file,
            'status'        => $status,
            'dibuat_oleh'   => $user->id_user,
        ]);

        // TRACKING
        TrackingSurat::create([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
            'aksi'       => 'Surat dibuat',
        ]);

        // SURAT INTERNAL / UNIT -> KE SEKRETARIS
        if ($status == 'menunggu_sekretaris') {
            $sekretaris = User::where('id_jabatan', 4)->pluck('id_user')->toArray();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Masuk Baru',
                'Ada surat baru menunggu proses sekretaris',
                '/eoffice/surat-masuk/' . $surat->id . '/edit',
                'info'
            );
        }

        // SEKRETARIS INPUT LANGSUNG -> DIREKTUR / KABAG
        if (in_array($status, ['menunggu_direktur', 'menunggu_kabag'])) {
            foreach ($request->tag_users ?? [] as $userId) {
                SuratTag::create([
                    'surat_id'   => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id'    => $userId,
                ]);

                $tagUser = User::find($userId);

                if ($tagUser && $tagUser->id_jabatan == 1) {
                    Persetujuan::create([
                        'surat_id'      => $surat->id,
                        'surat_type'    => SuratMasuk::class,
                        'user_id'       => $userId,
                        'role_approver' => 'direktur',
                        'status'        => 'menunggu',
                    ]);
                }

                if ($tagUser && $tagUser->id_jabatan == 2) {
                    Persetujuan::create([
                        'surat_id'      => $surat->id,
                        'surat_type'    => SuratMasuk::class,
                        'user_id'       => $userId,
                        'role_approver' => 'kabag',
                        'status'        => 'menunggu',
                    ]);
                }
            }

            // KIRIM NOTIF SESUAI ALUR
            if ($adaDirektur) {
                $direkturIds = $tagUsers->where('id_jabatan', 1)->pluck('id_user')->toArray();

                Notifikasi::kirimKe(
                    $direkturIds,
                    'Surat Menunggu Persetujuan',
                    'Ada surat baru menunggu approval direktur.',
                    '/eoffice/surat-masuk/' . $surat->id,
                    'peringatan'
                );
            } elseif ($adaKabag) {
                $kabagIds = $tagUsers->where('id_jabatan', 2)->pluck('id_user')->toArray();

                Notifikasi::kirimKe(
                    $kabagIds,
                    'Surat Menunggu Persetujuan Kabag',
                    'Ada surat baru menunggu approval kabag.',
                    '/eoffice/surat-masuk/' . $surat->id . '#approval',
                    'peringatan'
                );
            }
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
        $user  = Auth::user();
        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'prioritas'    => 'required|in:biasa,sedang,segera',
            'nomor_agenda' => 'required|string',
        ]);

        // MODE EDIT SAJA (tanpa disposisi)
        if ($request->has('edit_only')) {
            $surat->update([
                'nomor_agenda' => $request->nomor_agenda,
                'prioritas'    => $request->prioritas,
                'catatan'      => $request->catatan,
            ]);

            TrackingSurat::create([
                'surat_id'   => $surat->id,
                'surat_type' => SuratMasuk::class,
                'user_id'    => $user->id_user,
                'aksi'       => 'Surat diedit oleh sekretaris',
            ]);

            return redirect()
                ->route('eoffice.surat-masuk.index')
                ->with('success', 'Surat berhasil diperbarui.');
        }

        /*
        |--------------------------------------------------------------------------
        | DISPOSISI: TENTUKAN STATUS & TAG USERS
        |--------------------------------------------------------------------------
        */
        $tagUsers    = User::whereIn('id_user', $request->tag_users ?? [])->get();
        $adaDirektur = $tagUsers->contains('id_jabatan', 1);
        $adaKabag    = $tagUsers->contains('id_jabatan', 2);

        if ($adaDirektur) {
            $status = 'menunggu_direktur';
        } elseif ($adaKabag) {
            $status = 'menunggu_kabag';
        } else {
            $status = 'menunggu_direktur'; // fallback
        }

        $surat->update([
            'nomor_agenda'  => $request->nomor_agenda,
            'tanggal_masuk' => $request->tanggal_masuk ?? $surat->tanggal_masuk,
            'status'        => $status,
            'prioritas'     => $request->prioritas,
            'catatan'       => $request->catatan,
        ]);

        // Tandai notif sekretaris sudah dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/' . $surat->id . '/edit')
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        // Hapus tag & persetujuan lama
        SuratTag::where('surat_id', $surat->id)->delete();
        Persetujuan::where('surat_id', $surat->id)->delete();

        /*
        |--------------------------------------------------------------------------
        | BUAT TAG, PERSETUJUAN, DAN NOTIF BARU
        |--------------------------------------------------------------------------
        */
        foreach ($request->tag_users ?? [] as $userId) {
            SuratTag::create([
                'surat_id'   => $surat->id,
                'surat_type' => SuratMasuk::class,
                'user_id'    => $userId,
            ]);

            $tagUser = User::find($userId);

            // DIREKTUR
            if ($tagUser && $tagUser->id_jabatan == 1) {
                Persetujuan::create([
                    'surat_id'      => $surat->id,
                    'surat_type'    => SuratMasuk::class,
                    'user_id'       => $userId,
                    'role_approver' => 'direktur',
                    'status'        => 'menunggu',
                ]);

                // Hapus notif lama direktur lalu kirim baru
                Notifikasi::where('id_user', $userId)
                    ->where('url', '/eoffice/surat-masuk/' . $surat->id)
                    ->where('judul', 'Surat Menunggu Persetujuan')
                    ->delete();

                Notifikasi::kirim(
                    $userId,
                    'Surat Menunggu Persetujuan',
                    'Ada surat baru menunggu approval direktur.',
                    '/eoffice/surat-masuk/' . $surat->id,
                    'peringatan'
                );
            }

            // KABAG
            if ($tagUser && $tagUser->id_jabatan == 2) {
                Persetujuan::create([
                    'surat_id'      => $surat->id,
                    'surat_type'    => SuratMasuk::class,
                    'user_id'       => $userId,
                    'role_approver' => 'kabag',
                    'status'        => 'menunggu',
                ]);

                // Notif kabag dikirim HANYA jika tidak ada direktur.
                // Jika ada direktur, kabag akan dapat notif setelah direktur approve
                // (ditangani di method setujui).
                if (!$adaDirektur) {
                    // Hapus notif lama kabag
                    Notifikasi::where('id_user', $userId)
                        ->where(function ($q) use ($surat) {
                            $q->where('url', '/eoffice/surat-masuk/' . $surat->id)
                                ->orWhere('url', '/eoffice/surat-masuk/' . $surat->id . '#approval');
                        })
                        ->delete();

                    Notifikasi::kirim(
                        $userId,
                        'Surat Menunggu Persetujuan Kabag',
                        'Ada surat baru menunggu approval kabag.',
                        '/eoffice/surat-masuk/' . $surat->id . '#approval',
                        'peringatan'
                    );
                }
            }
        } // end foreach tag_users

        /*
        |--------------------------------------------------------------------------
        | NOTIF KE PENGIRIM / PEMBUAT SURAT
        |--------------------------------------------------------------------------
        */
        Notifikasi::where('id_user', $surat->dibuat_oleh)
            ->where('url', '/eoffice/surat-masuk/' . $surat->id)
            ->where('judul', 'Surat Diproses Sekretaris')
            ->delete();

        if ($adaDirektur && $adaKabag) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke direktur serta kabag.';
        } elseif ($adaDirektur) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke direktur.';
        } elseif ($adaKabag) {
            $pesanPengirim = 'Surat diproses sekretaris dan diteruskan ke kabag.';
        } else {
            $pesanPengirim = 'Surat diproses sekretaris.';
        }

        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Diproses Sekretaris',
            $pesanPengirim,
            '/eoffice/surat-masuk/' . $surat->id,
            'info'
        );

        /*
        |--------------------------------------------------------------------------
        | TRACKING
        |--------------------------------------------------------------------------
        */
        if ($adaDirektur && $adaKabag) {
            $aksiTracking = 'Surat diteruskan ke direktur dan kabag';
        } elseif ($adaDirektur) {
            $aksiTracking = 'Surat diteruskan ke direktur';
        } elseif ($adaKabag) {
            $aksiTracking = 'Surat diteruskan ke kabag';
        } else {
            $aksiTracking = 'Surat diteruskan';
        }

        TrackingSurat::create([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
            'aksi'       => $aksiTracking,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil diteruskan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SETUJUI SURAT
    |--------------------------------------------------------------------------
    */
    public function setujui(Request $request, $id)
    {
        $user  = Auth::user();
        $surat = SuratMasuk::findOrFail($id);

        $persetujuan = Persetujuan::where([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
        ])->first();

        if (!$persetujuan) {
            return back()->with('error', 'Anda tidak memiliki akses approval.');
        }

        // Update approval
        $persetujuan->update([
            'status'      => 'disetujui',
            'catatan'     => $request->catatan,
            'approved_at' => now(),
        ]);

        // Tandai notif approval sudah dibaca
        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/' . $surat->id)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        /*
        |--------------------------------------------------------------------------
        | DIREKTUR MENYETUJUI
        |--------------------------------------------------------------------------
        */
        if ($user->id_jabatan == 1) {
            $adaKabag = Persetujuan::where([
                'surat_id'      => $surat->id,
                'surat_type'    => SuratMasuk::class,
                'role_approver' => 'kabag',
            ])->exists();

            $surat->update([
                'status' => $adaKabag ? 'menunggu_kabag' : 'disetujui',
            ]);

            // Hapus tag unit lama lalu buat ulang dari pilihan direktur
            SuratTag::where([
                'surat_id'   => $surat->id,
                'surat_type' => SuratMasuk::class,
            ])->whereHas('user', function ($q) {
                $q->where('id_jabatan', 3);
            })->delete();

            foreach ($request->tag_units ?? [] as $unitId) {
                SuratTag::create([
                    'surat_id'   => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id'    => $unitId,
                ]);

                Notifikasi::kirim(
                    $unitId,
                    'Surat Ditugaskan Direktur',
                    'Ada surat yang ditugaskan direktur untuk unit Anda.',
                    '/eoffice/surat-masuk/' . $surat->id,
                    'info'
                );
            }

            // Notif ke kabag (jika ada)
            $kabagIds = Persetujuan::where([
                'surat_id'      => $surat->id,
                'surat_type'    => SuratMasuk::class,
                'role_approver' => 'kabag',
            ])->pluck('user_id')->toArray();

            if (!empty($kabagIds)) {
                Notifikasi::kirimKe(
                    $kabagIds,
                    'Surat Menunggu Persetujuan Kabag',
                    'Ada surat menunggu approval kabag.',
                    '/eoffice/surat-masuk/' . $surat->id . '#approval',
                    'peringatan'
                );
            }

            // Notif ke sekretaris
            $sekretaris = User::where('id_jabatan', 4)->pluck('id_user')->toArray();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Disetujui Direktur',
                $adaKabag
                    ? 'Surat telah disetujui direktur dan diteruskan ke kabag.'
                    : 'Surat telah disetujui direktur dan selesai.',
                '/eoffice/surat-masuk/' . $surat->id,
                'sukses'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KABAG MENYETUJUI
        |--------------------------------------------------------------------------
        */
        if ($user->id_jabatan == 2) {
            $surat->update(['status' => 'disetujui']);

            // Tandai notif kabag sudah dibaca
            Notifikasi::where('id_user', $user->id_user)
                ->where('url', '/eoffice/surat-masuk/' . $surat->id)
                ->where('dibaca', false)
                ->update(['dibaca' => true]);

            // Notif ke pembuat surat
            Notifikasi::where('id_user', $surat->dibuat_oleh)
                ->where('url', '/eoffice/surat-masuk/' . $surat->id)
                ->where('judul', 'Surat Disetujui Kabag')
                ->delete();

            Notifikasi::kirim(
                $surat->dibuat_oleh,
                'Surat Disetujui Kabag',
                'Surat yang kamu kirim telah disetujui kabag.',
                '/eoffice/surat-masuk/' . $surat->id,
                'sukses'
            );

            // Notif ke sekretaris
            $sekretaris = User::where('id_jabatan', 4)->pluck('id_user')->toArray();

            Notifikasi::whereIn('id_user', $sekretaris)
                ->where('url', '/eoffice/surat-masuk/' . $surat->id)
                ->where('judul', 'Surat Disetujui Kabag')
                ->delete();

            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Disetujui Kabag',
                'Surat telah disetujui kabag.',
                '/eoffice/surat-masuk/' . $surat->id,
                'sukses'
            );

            // Notif ke unit yang ditag
            $unitIds = SuratTag::where([
                'surat_id'   => $surat->id,
                'surat_type' => SuratMasuk::class,
            ])->whereHas('user', function ($q) {
                $q->where('id_jabatan', 3);
            })->pluck('user_id')->toArray();

            if (!empty($unitIds)) {
                Notifikasi::kirimKe(
                    $unitIds,
                    'Surat Disetujui Kabag',
                    'Surat telah disetujui kabag dan dapat diproses unit.',
                    '/eoffice/surat-masuk/' . $surat->id,
                    'sukses'
                );
            }
        }

        // TRACKING
        TrackingSurat::create([
            'surat_id'    => $surat->id,
            'surat_type'  => SuratMasuk::class,
            'user_id'     => $user->id_user,
            'aksi'        => 'Surat disetujui',
            'keterangan'  => $request->catatan,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.show', $surat->id)
            ->with('success', 'Surat berhasil disetujui.');
    }

    /*
    |--------------------------------------------------------------------------
    | PENDING SURAT (KABAG)
    |--------------------------------------------------------------------------
    */
    public function pending(Request $request, $id)
    {
        $user  = Auth::user();
        $surat = SuratMasuk::findOrFail($id);

        if ($user->id_jabatan != 2) {
            abort(403);
        }

        $surat->update([
            'status'  => 'pending',
            'catatan' => $request->catatan,
        ]);

        $persetujuan = Persetujuan::where([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
        ])->first();

        if ($persetujuan) {
            $persetujuan->update([
                'status'  => 'pending',
                'catatan' => $request->catatan,
            ]);
        }

        Notifikasi::where('id_user', $user->id_user)
            ->where('url', '/eoffice/surat-masuk/' . $surat->id)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        // Notif ke pembuat surat
        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Dipending',
            'Surat dipending oleh Kabag. Catatan: ' . $request->catatan,
            '/eoffice/surat-masuk/' . $surat->id,
            'peringatan'
        );

        // Notif ke sekretaris
        $sekretaris = User::where('id_jabatan', 4)->pluck('id_user')->toArray();

        Notifikasi::whereIn('id_user', $sekretaris)
            ->where('url', '/eoffice/surat-masuk/' . $surat->id)
            ->where('judul', 'Surat Dipending')
            ->delete();

        Notifikasi::kirimKe(
            $sekretaris,
            'Surat Dipending',
            'Surat dipending oleh kabag.',
            '/eoffice/surat-masuk/' . $surat->id,
            'peringatan'
        );

        // Notif ke unit yang ditag
        $unitIds = SuratTag::where([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
        ])->whereHas('user', function ($q) {
            $q->where('id_jabatan', 3);
        })->pluck('user_id')->toArray();

        if (!empty($unitIds)) {
            Notifikasi::kirimKe(
                $unitIds,
                'Surat Dipending Kabag',
                'Surat dipending oleh kabag.',
                '/eoffice/surat-masuk/' . $surat->id,
                'peringatan'
            );
        }

        TrackingSurat::create([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
            'aksi'       => 'Surat dipending',
            'keterangan' => $request->catatan,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.show', $surat->id)
            ->with('success', 'Surat berhasil dipending.');
    }

    public function tolak(Request $request, $id)
    {
        $user = Auth::user();

        $surat = SuratMasuk::findOrFail($id);

        $persetujuan = Persetujuan::where([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
        ])->first();

        if (!$persetujuan) {
            return back()->with('error', 'Anda tidak memiliki akses approval.');
        }

        // UPDATE STATUS PERSETUJUAN
        $persetujuan->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
            'approved_at' => now(),
        ]);

        // UPDATE STATUS SURAT
        $surat->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        // NOTIF KE PEMBUAT SURAT
        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Ditolak',
            'Surat ditolak oleh ' . ($user->id_jabatan == 1 ? 'Direktur' : 'Kabag'),
            '/eoffice/surat-masuk/' . $surat->id,
            'bahaya'
        );

        // NOTIF KE SEKRETARIS
        $sekretaris = User::where('id_jabatan', 4)
            ->pluck('id_user')
            ->reject(function ($id) use ($surat) {
                return $id == $surat->dibuat_oleh;
            })
            ->values()
            ->toArray();

        if (!empty($sekretaris)) {
            Notifikasi::kirimKe(
                $sekretaris,
                'Surat Ditolak',
                'Surat ditolak oleh ' . ($user->id_jabatan == 1 ? 'Direktur' : 'Kabag'),
                '/eoffice/surat-masuk/' . $surat->id,
                'bahaya'
            );

        }

        // NOTIF KE UNIT YANG DITAG
        $unitIds = SuratTag::where([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
        ])->whereHas('user', function ($q) {
            $q->where('id_jabatan', 3);
        })
        ->pluck('user_id')
        ->unique()
        ->reject(function ($id) use ($surat) {
            return $id == $surat->dibuat_oleh;
        })
        ->values()
        ->toArray();
            if (!empty($unitIds)) {

                Notifikasi::kirimKe(
                    $unitIds,
                    'Surat Ditolak',
                    'Surat ditolak oleh ' . ($user->id_jabatan == 1 ? 'Direktur' : 'Kabag'),
                    '/eoffice/surat-masuk/' . $surat->id,
                    'bahaya'
                );
            }

        // TRACKING
        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat ditolak',
            'keterangan' => $request->catatan,
        ]);

        return redirect()
            ->route('eoffice.surat-masuk.show', $surat->id)
            ->with('success', 'Surat berhasil ditolak.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new SuratMasukExport(
                $request->bulan,
                $request->tahun
            ),
            'surat-masuk.xlsx'
        );
    }

    public function exportPdf($id)
    {
        return redirect()->back()->with('info', 'Fitur PDF segera hadir.');
    }
}