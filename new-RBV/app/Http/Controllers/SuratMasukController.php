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
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = SuratMasuk::with([
            'pembuat.unitKerjaRelation'
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
        $surat = SuratMasuk::findOrFail($id);
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
        $surat = SuratMasuk::with([
            'pembuat',
            'tags.user',
            'persetujuans.user',
            'tracking.user',
        ])->findOrFail($id);

        // CEK APAKAH USER BISA APPROVE

        $bisaApprove = false;
        $jabatanApproval = null;

        // Direktur
        if (
            $user->id_jabatan == 1 &&
            $surat->status == 'menunggu_direktur'
        ) {
            $bisaApprove = true;
            $jabatanApproval = 'direktur';
        }

        // Kabag
        if (
            $user->id_jabatan == 2 &&
            in_array($surat->status, [
                'menunggu_kabag',
                'pending'
            ])
        ) {

            $bisaApprove = true;
            $jabatanApproval = 'kabag';
        }

        // UNIT TERKAIT

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
            'nomor_agenda' => 'required',
            'nomor_surat' => 'nullable',
            'tanggal_surat' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'asal_surat' => 'required',
            'prioritas' => 'nullable|in:biasa,sedang,segera',
            'jenis' => 'required|in:internal,external',
            'perihal' => 'required',
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
                    'jenis' => 'Karyawan/unit hanya dapat membuat surat internal.'
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

        // Jika sekretaris membuat surat external langsung ke direktur

        if (
            $user->id_jabatan == 4 &&
            $request->jenis == 'external'
        ) {
            $status = 'menunggu_direktur';
        }

        $surat = SuratMasuk::create([
            'nomor_agenda' => $request->nomor_agenda,
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
                '/eoffice/surat-masuk/' . $surat->id,
                'info'
            );
        }

        //  EXTERNAL SEKRETARIS -> DIREKTUR/KABAG

        if ($status == 'menunggu_direktur') {
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

            $penerima = User::whereIn('id_jabatan', [1, 2])
                ->pluck('id_user')
                ->toArray();

            Notifikasi::kirimKe(
                $penerima,
                'Surat Menunggu Persetujuan',
                'Ada surat baru menunggu approval',
                '/eoffice/surat-masuk/' . $surat->id,
                'peringatan'
            );
        }

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $surat = SuratMasuk::findOrFail($id);
        $request->validate([
            'prioritas' => 'required|in:biasa,sedang,segera',
        ]);

        // HANYA SEKRETARIS

        if ($user->id_jabatan != 4) {
            abort(403);
        }

        // UPDATE STATUS

        $surat->update([
            'status' => 'menunggu_direktur',
            'prioritas' => $request->prioritas,
            'catatan'   => $request->catatan,
        ]);

        //  TAG USER

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

            //  KABAG

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

        //  TRACKING

        TrackingSurat::create([
            'surat_id' => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id' => $user->id_user,
            'aksi' => 'Surat diteruskan ke direktur dan kabag',
        ]);

        // NOTIF

        $penerima = User::whereIn('id_jabatan', [1, 2])
            ->pluck('id_user')
            ->toArray();

        Notifikasi::kirimKe(
            $penerima,
            'Surat Menunggu Persetujuan',
            'Ada surat baru menunggu approval',
            '/eoffice/surat-masuk/' . $surat->id,
            'peringatan'
        );

        return redirect()
            ->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil diteruskan.');
    }

    public function setujui(Request $request, $id)
    {
        $user = Auth::user();
        $surat = SuratMasuk::findOrFail($id);

        // CARI DATA PERSETUJUAN USER

        $persetujuan = Persetujuan::where([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
        ])->first();

        if (!$persetujuan) {

            return back()->with(
                'error',
                'Anda tidak memiliki akses approval.'
            );

        }

        // UPDATE APPROVAL

        $persetujuan->update([
            'status'      => 'disetujui',
            'catatan'     => $request->catatan,
            'approved_at' => now(),
        ]);

        // JIKA DIREKTUR SETUJU

        if ($user->id_jabatan == 1) {

            $surat->update([
                'status' => 'menunggu_kabag',
            ]);

            // TAG UNIT TERKAIT

            foreach ($request->tag_units ?? [] as $unitUserId) {
                SuratTag::create([
                    'surat_id'   => $surat->id,
                    'surat_type' => SuratMasuk::class,
                    'user_id'    => $unitUserId,
                ]);

                // NOTIF KE UNIT YANG DI TAG

                Notifikasi::kirim(
                    $unitUserId,
                    'Kamu Ditandai Dalam Surat',
                    'Direktur menandai kamu pada surat yang perlu ditindaklanjuti.',
                    '/eoffice/surat-masuk/' . $surat->id,
                    'info'
                );
            }

            // NOTIF KE KABAG

            $kabag = User::where('id_jabatan', 2)
                ->pluck('id_user')
                ->toArray();

            Notifikasi::kirimKe(
                $kabag,
                'Surat Menunggu Persetujuan Kabag',
                'Ada surat yang sudah disetujui direktur dan menunggu approval kabag.',
                '/eoffice/surat-masuk/' . $surat->id,
                'info'
            );
        }

        // JIKA KABAG SETUJU

        if ($user->id_jabatan == 2) {

            $surat->update([
                'status' => 'disetujui',
            ]);

            // NOTIF KE PEMBUAT SURAT

            Notifikasi::kirim(
                $surat->dibuat_oleh,
                'Surat Disetujui',
                'Surat yang kamu kirim telah disetujui.',
                '/eoffice/surat-masuk/' . $surat->id,
                'sukses'
            );
        }

        // TRACKING

        TrackingSurat::create([
            'surat_id'   => $surat->id,
            'surat_type' => SuratMasuk::class,
            'user_id'    => $user->id_user,
            'aksi'       => 'Surat disetujui',
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
            'status'  => 'pending',
            'catatan' => $request->catatan,
        ]);

        // UPDATE PERSETUJUAN

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

        // NOTIF KE PEMBUAT SURAT

        Notifikasi::kirim(
            $surat->dibuat_oleh,
            'Surat Dipending',
            'Surat dipending oleh Kabag. Catatan: ' . $request->catatan,
            '/eoffice/surat-masuk/' . $surat->id,
            'peringatan'
        );

        //  TRACKING

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
}