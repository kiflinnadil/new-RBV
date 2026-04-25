<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    private function getDummyData()
    {
        return collect([
            (object) [
                'id' => 1,
                'nomor_agenda' => '001/2026',
                'nomor_surat' => '001/RSCH/SM/III/2026',
                'tanggal_surat' => Carbon::now()->subDays(5),
                'tanggal_masuk' => Carbon::now()->subDays(2),
                'asal_surat' => 'Unit Keuangan',
                'perihal' => 'Pengajuan Anggaran Pembelian ATK',
                'jenis' => 'internal',
                'prioritas' => null, 
                'status' => 'menunggu_sekretaris',
                'catatan' => null,
                'catatan_tolak' => null,
                'catatan_pending' => null,
                'file_scan' => null,
                'pembuat' => (object) [
                    'id_user' => 5,
                    'nama_lengkap' => 'Bejo Santoso',
                    'unit_kerja' => 'Unit Keuangan',
                    'kategori_unit' => 'Keuangan',
                    'role' => 'karyawan',
                ],
                'tags' => collect([]),
                'persetujuan' => collect([]),
                'tracking' => collect([
                    (object) [
                        'aksi' => 'Surat dikirim oleh unit',
                        'user' => (object) ['nama_lengkap' => 'Bejo Santoso'],
                        'created_at' => Carbon::now()->subDays(2),
                        'keterangan' => null,
                    ],
                ]),
            ],
            (object) [
                'id' => 2,
                'nomor_agenda' => '002/2026',
                'nomor_surat' => '002/RSCH/SM/III/2026',
                'tanggal_surat' => Carbon::now()->subDays(3),
                'tanggal_masuk' => Carbon::now()->subDay(),
                'asal_surat' => 'Dinas Kesehatan',
                'perihal' => 'Permohonan Kerjasama Pengadaan Alkes',
                'jenis' => 'external',
                'prioritas' => 'sedang',
                'status' => 'menunggu_direktur',
                'catatan' => 'Mohon segera ditindaklanjuti sebelum akhir bulan.',
                'catatan_tolak' => null,
                'catatan_pending' => null,
                'file_scan' => null,
                'pembuat' => (object) [
                    'id_user' => 6,
                    'nama_lengkap' => 'Apt. Dewi',
                    'unit_kerja' => 'Unit Farmasi',
                    'kategori_unit' => 'Penunjang Medis',
                    'role' => 'unit',
                ],
                'tags' => collect([
                    (object) ['user' => (object) ['nama_lengkap' => 'Dr. Budi (Direktur)', 'role' => 'super_admin']],
                    (object) ['user' => (object) ['nama_lengkap' => 'H. Ahmad (Kabag)',    'role' => 'super_admin']],
                ]),
                'persetujuan' => collect([
                    (object) [
                        'role_approver' => 'direktur',
                        'user' => (object) ['nama_lengkap' => 'Dr. Budi'],
                        'status' => 'menunggu',
                        'catatan' => null,
                        'approved_at' => null,
                    ],
                    (object) [
                        'role_approver' => 'kabag',
                        'user' => (object) ['nama_lengkap' => 'H. Ahmad'],
                        'status' => 'menunggu',
                        'catatan' => null,
                        'approved_at' => null,
                    ],
                ]),
                'tracking' => collect([
                    (object) [
                        'aksi' => 'Surat dikirim oleh unit',
                        'user' => (object) ['nama_lengkap' => 'Apt. Dewi'],
                        'created_at' => Carbon::now()->subDays(3),
                        'keterangan' => null,
                    ],
                    (object) [
                        'aksi' => 'Diteruskan ke Direktur oleh Sekretaris',
                        'user' => (object) ['nama_lengkap' => 'Siti Rahayu'],
                        'created_at' => Carbon::now()->subDay(),
                        'keterangan' => 'Prioritas: Sedang',
                    ],
                ]),
            ],
            (object) [
                'id' => 3,
                'nomor_agenda' => '003/2026',
                'nomor_surat' => '003/RSCH/SM/IV/2026',
                'tanggal_surat' => Carbon::now()->subDays(1),
                'tanggal_masuk' => Carbon::now(),
                'asal_surat' => 'BPJS Kesehatan',
                'perihal' => 'Klaim Pembayaran Bulan Maret 2026',
                'jenis' => 'external',
                'prioritas' => 'biasa',
                'status' => 'disetujui',
                'catatan' => 'Sudah diverifikasi keuangan.',
                'catatan_tolak' => null,
                'catatan_pending' => null,
                'file_scan' => null,
                'pembuat' => (object) [
                    'id_user' => 4,
                    'nama_lengkap' => 'Siti Rahayu',
                    'unit_kerja' => 'Sekretariat',
                    'kategori_unit' => 'Umum',
                    'role' => 'sekretaris',
                ],
                'tags' => collect([
                    (object) ['user' => (object) ['nama_lengkap' => 'Bejo (Unit Keuangan)', 'role' => 'karyawan']],
                ]),
                'persetujuan' => collect([
                    (object) [
                        'role_approver' => 'direktur',
                        'user' => (object) ['nama_lengkap' => 'Dr. Budi'],
                        'status' => 'disetujui',
                        'catatan' => 'Disetujui, segera diproses.',
                        'approved_at' => Carbon::now()->subHours(3),
                    ],
                    (object) [
                        'role_approver' => 'kabag',
                        'user' => (object) ['nama_lengkap' => 'H. Ahmad'],
                        'status' => 'disetujui',
                        'catatan' => 'OK.',
                        'approved_at' => Carbon::now()->subHour(),
                    ],
                ]),
                'tracking' => collect([
                    (object) ['aksi' => 'Surat diinput sekretaris',  'user' => (object) ['nama_lengkap' => 'Siti Rahayu'], 'created_at' => Carbon::now()->subDay(),    'keterangan' => null],
                    (object) ['aksi' => 'Diteruskan ke Direktur',    'user' => (object) ['nama_lengkap' => 'Siti Rahayu'], 'created_at' => Carbon::now()->subHours(5), 'keterangan' => null],
                    (object) ['aksi' => 'Disetujui oleh Direktur',   'user' => (object) ['nama_lengkap' => 'Dr. Budi'],    'created_at' => Carbon::now()->subHours(3), 'keterangan' => 'Disetujui, segera diproses.'],
                    (object) ['aksi' => 'Disetujui oleh Kabag',      'user' => (object) ['nama_lengkap' => 'H. Ahmad'],    'created_at' => Carbon::now()->subHour(),   'keterangan' => 'OK.'],
                ]),
            ],
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $data = $this->getDummyData();

        if (in_array($user->role, ['unit', 'karyawan'])) {
            $data = $data->filter(fn ($s) => $s->pembuat->id_user === $user->id_user);
        }
        if ($user->jabatan === 'direktur') {
            $data = $data->filter(fn ($s) => $s->status !== 'menunggu_sekretaris');
        }

        if ($user->jabatan === 'kabag') {
            $data = $data->filter(fn ($s) => in_array($s->status, [
                'menunggu_kabag',
                'pending',
                'disetujui',
                'ditolak',
            ]));
        }

        if ($request->filled('unit')) {
            $data = $data->filter(fn ($s) => ($s->pembuat->unit_kerja ?? '') === $request->unit);
        } elseif ($request->filled('kategori')) {
            $kategoriUnits = $kategoriList[$request->kategori] ?? [];
            $data = $data->filter(fn ($s) => in_array($s->pembuat->unit_kerja ?? '', $kategoriUnits));
        }

        if ($request->filled('prioritas')) {
            $data = $data->filter(fn ($s) => $s->prioritas === $request->prioritas);
        }
        if ($request->filled('status')) {
            $data = $data->filter(fn ($s) => $s->status === $request->status);
        }

        if ($request->filled('search')) {
            $q = strtolower($request->search);
            $data = $data->filter(fn ($s) => str_contains(strtolower($s->perihal), $q) ||
                str_contains(strtolower($s->nomor_agenda), $q) ||
                str_contains(strtolower($s->nomor_surat ?? ''), $q) ||
                str_contains(strtolower($s->asal_surat), $q)
            );
        }

        $suratMenunggu = $this->getDummyData()->where('status', 'menunggu_sekretaris')->count();

        $kategoriList = [
            'Kabid Keperawatan' => [
                'Unit Poliklinik Rawat Jalan',
                'Instalasi Gawat Darurat',
                'Unit Rawat Inap Ruang Lotus',
                'Unit Rawat Inap Ruang Rosalina',
                'Unit Rawat Inap Ruang Alamanda',
                'Unit Rawat Inap Ruang Teratai',
                'Unit Rawat Inap Ruang Anturium',
                'Unit Rawat Inap Ruang Tulip',
                'Unit Kamar Operasi',
                'Unit ICU',
                'Unit Hemodialisis',
                'Unit Kamar Bersalin',
                'Unit Perinatologi',
            ],
            'Kabid Pelayanan Medis' => [
                'Unit Poliklinik Rawat Jalan',
                'Instalasi Gawat Darurat',
                'Unit Rawat Inap Ruang Lotus',
                'Unit Rawat Inap Ruang Rosalina',
                'Unit Rawat Inap Ruang Alamanda',
                'Unit Rawat Inap Ruang Teratai',
                'Unit Rawat Inap Ruang Anturium',
                'Unit Rawat Inap Ruang Tulip',
                'Unit Kamar Operasi',
                'Unit ICU',
                'Unit Hemodialisis',
                'Unit Kamar Bersalin',
                'Unit Perinatologi',
            ],
            'Kabid Penunjang Medis' => [
                'Unit Radiologi',
                'Unit Laboratorium',
                'Unit Gizi',
                'Unit Farmasi',
                'Unit Rekam Medik',
            ],
            'Kabag Umum & Keuangan' => [
                'Unit Umum Rumah Tangga',
                'Unit Informasi & TI',
                'Unit Keuangan',
                'Unit Pajak',
                'Unit Akuntansi',
                'Unit Kepegawaian & Diklat',
            ],
        ];

        $perPage = 15;
        $page = $request->input('page', 1);
        $items = $data->forPage($page, $perPage)->values();

        $suratMasuk = new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $data->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.E-Office.SuratMasuk.suratmasuk', compact(
            'suratMasuk', 'suratMenunggu', 'kategoriList'
        ));
    }

    public function create()
    {
        $user = Auth::user();

        if (in_array($user->role, ['unit', 'karyawan'])) {
            $usersTag = collect([
                (object) ['id_user' => 4, 'nama_lengkap' => 'Siti Rahayu',    'jabatan' => 'Sekretaris'],
                (object) ['id_user' => 7, 'nama_lengkap' => 'Dewi Anggraeni', 'jabatan' => 'Sekretaris'],
            ]);
        } else {
            $usersTag = collect([
                (object) ['id_user' => 1, 'nama_lengkap' => 'Dr. Budi Santoso', 'jabatan' => 'Direktur'],
                (object) ['id_user' => 2, 'nama_lengkap' => 'H. Ahmad Fauzi',   'jabatan' => 'Kabag Umum'],
            ]);
        }

        return view('pages.E-Office.SuratMasuk.suratmasuk_create', compact('usersTag'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $isUnit = in_array($user->role, ['unit', 'karyawan']);

        $rules = [
            'nomor_agenda' => 'required|string',
            'nomor_surat' => 'nullable|string',
            'tanggal_surat' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'asal_surat' => 'required|string',
            'jenis' => 'required|in:internal,external',
            'perihal' => 'required|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'tag_users' => 'nullable|array',
        ];

        if (! $isUnit) {
            $rules['prioritas'] = 'required|in:biasa,sedang,segera';
        }

        $request->validate($rules);

        return redirect()->route('eoffice.surat-masuk.index')
            ->with('success', $isUnit
                ? 'Surat berhasil dikirim ke sekretaris.'
                : 'Surat masuk berhasil ditambahkan.'
            );
    }

    public function show($id)
    {
        $surat = $this->getDummyData()->firstWhere('id', (int) $id);
        abort_if(! $surat, 404);

        $user = Auth::user();
        $jabatanApproval = in_array($user->jabatan, ['direktur', 'kabag']) ? $user->jabatan : null;
        $myPersetujuan = $jabatanApproval
            ? $surat->persetujuan->where('role_approver', $jabatanApproval)->first()
            : null;
        $bisaApprove = $myPersetujuan
            && $myPersetujuan->status === 'menunggu'
            && in_array($surat->status, ['menunggu_direktur', 'menunggu_kabag']);

        $unitsTerkait = collect([
            (object) ['id_user' => 5, 'nama_lengkap' => 'Bejo Santoso',   'unit_kerja' => 'Unit Keuangan'],
            (object) ['id_user' => 6, 'nama_lengkap' => 'Apt. Dewi',      'unit_kerja' => 'Unit Farmasi'],
            (object) ['id_user' => 8, 'nama_lengkap' => 'dr. Andi',       'unit_kerja' => 'Unit Rawat Inap'],
            (object) ['id_user' => 9, 'nama_lengkap' => 'Sari Wulandari', 'unit_kerja' => 'Unit Laboratorium'],
        ]);

        return view('pages.E-Office.SuratMasuk.suratmasuk_show', compact(
            'surat', 'bisaApprove', 'jabatanApproval', 'unitsTerkait'
        ));
    }

    public function edit($id)
    {
        $surat = $this->getDummyData()->firstWhere('id', (int) $id);
        abort_if(! $surat, 404);

        $usersTag = collect([
            (object) ['id_user' => 1, 'nama_lengkap' => 'Dr. Budi Santoso', 'jabatan' => 'Direktur'],
            (object) ['id_user' => 2, 'nama_lengkap' => 'H. Ahmad Fauzi',   'jabatan' => 'Kabag Umum'],
        ]);

        return view('pages.E-Office.SuratMasuk.suratmasuk_edit', compact('surat', 'usersTag'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->boolean('aksi_kabag') || $user->jabatan === 'kabag') {
            $request->validate([
                'catatan' => 'nullable|string',
                'status_baru' => 'required|in:disetujui,ditolak',
            ]);

            $pesan = $request->status_baru === 'disetujui'
                ? 'Surat berhasil disetujui.'
                : 'Surat berhasil ditolak.';

            return redirect()->route('eoffice.surat-masuk.index')
                ->with('success', $pesan);
        }

        $request->validate([
            'prioritas' => 'required|in:biasa,sedang,segera',
            'catatan' => 'nullable|string',
            'tag_users' => 'required|array|min:1',
        ]);

        return redirect()->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil diteruskan ke Direktur.');
    }

    public function setujui(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'tag_units' => 'nullable|array',
        ]);

        return redirect()->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan_tolak' => 'required|string']);

        return redirect()->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat berhasil ditolak.');
    }

    public function pending(Request $request, $id)
    {
        $request->validate(['catatan_pending' => 'nullable|string']);

        return redirect()->route('eoffice.surat-masuk.index')
            ->with('success', 'Surat ditandai pending.');
    }

    public function export()
    {
        return redirect()->back()->with('info', 'Fitur export segera hadir.');
    }

    public function exportPdf($id)
    {
        return redirect()->back()->with('info', 'Fitur export PDF segera hadir.');
    }
}
