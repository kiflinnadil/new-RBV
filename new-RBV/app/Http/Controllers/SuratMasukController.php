<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {

        $suratMasuk = collect([
            (object) [
                'id' => 1,
                'nomor_agenda' => '001/2026',
                'nomor_surat' => 'SRT/123/III/2026',
                'tanggal_surat' => Carbon::now()->subDays(5),
                'tanggal_masuk' => Carbon::now()->subDays(2),
                'asal_surat' => 'Dinas Kesehatan',
                'perihal' => 'Permohonan Kerjasama Alkes',
                'prioritas' => 'segera',
                'status' => 'menunggu_direktur',
                'pembuat' => (object) ['nama_lengkap' => 'Sekretaris Utama'],
                'disposisi' => collect([(object) ['user' => (object) ['nama_lengkap' => 'Unit Farmasi']]]),
                'tags' => collect([(object) ['user' => (object) ['nama_lengkap' => 'Unit Farmasi']]]),
                'persetujuan' => collect([]),
            ],
            (object) [
                'id' => 2,
                'nomor_agenda' => '002/2026',
                'nomor_surat' => 'INT/005/2026',
                'tanggal_surat' => Carbon::now()->subDays(3),
                'tanggal_masuk' => Carbon::now()->subDay(),
                'asal_surat' => 'Unit Logistik',
                'perihal' => 'Pengajuan Perbaikan Gedung',
                'prioritas' => 'sedang',
                'status' => 'disetujui',
                'pembuat' => (object) ['nama_lengkap' => 'Sekretaris Utama'],
                'disposisi' => collect([(object) ['user' => (object) ['nama_lengkap' => 'Unit IT']]]),
                'tags' => collect([(object) ['user' => (object) ['nama_lengkap' => 'Unit Sarpras']]]),
                'persetujuan' => collect([]),
            ],
        ]);

        $suratMasuk = new \Illuminate\Pagination\LengthAwarePaginator($suratMasuk, $suratMasuk->count(), 15);
        $suratMasuk->setPath(url()->current());

        return view('pages.E-Office.SuratMasuk.suratmasuk', compact('suratMasuk'));
    }

    public function show($id)
    {

        $surat = (object) [
            'id' => $id,
            'nomor_agenda' => '001/2026',
            'nomor_surat' => 'SRT/123/III/2026',
            'tanggal_surat' => Carbon::now()->subDays(5),
            'tanggal_masuk' => Carbon::now()->subDays(2),
            'asal_surat' => 'Dinas Kesehatan',
            'perihal' => 'Permohonan Kerjasama Alkes',
            'jenis' => 'external',
            'prioritas' => 'segera',
            'catatan' => 'Mohon segera ditelaah untuk kerjasama bulan depan.',
            'catatan_tolak' => null,
            'file_scan' => null,
            'status' => 'menunggu_direktur',
            'tags' => collect([
                (object) ['user' => (object) ['nama_lengkap' => 'Unit Farmasi', 'role' => 'unit']],
                (object) ['user' => (object) ['nama_lengkap' => 'Kepala Lab', 'role' => 'unit']],
            ]),
            'persetujuan' => collect([
                (object) [
                    'role_approver' => 'direktur',
                    'user' => (object) ['nama_lengkap' => 'Dr. Budi (Direktur)'],
                    'status' => 'menunggu',
                    'catatan' => null,
                    'approved_at' => null,
                ],
                (object) [
                    'role_approver' => 'kabag',
                    'user' => (object) ['nama_lengkap' => 'H. Ahmad (Kabag)'],
                    'status' => 'menunggu',
                    'catatan' => null,
                    'approved_at' => null,
                ],
            ]),
            'tracking' => collect([
                (object) [
                    'aksi' => 'Surat diinput sekretaris',
                    'user' => (object) ['nama_lengkap' => 'Siti (Sekretaris)'],
                    'created_at' => Carbon::now()->subDays(2),
                    'keterangan' => 'File fisik sudah diterima',
                ],
            ]),
        ];

        $users = collect([]);
        $bisaApprove = true;

        return view('pages.E-Office.SuratMasuk.suratmasuk_show', compact('surat', 'users', 'bisaApprove'));
    }

    public function create()
    {
        $nomorAgenda = '003/2026';
        $users = collect([
            (object) ['id_user' => 1, 'nama_lengkap' => 'Unit IT'],
            (object) ['id_user' => 2, 'nama_lengkap' => 'Unit Keuangan'],
            (object) ['id_user' => 3, 'nama_lengkap' => 'Unit Sarpras'],
        ]);
        $suratMasuk = new \Illuminate\Pagination\LengthAwarePaginator(collect([]), 0, 15);

        return view('pages.E-Office.SuratMasuk.suratmasuk_create', compact('nomorAgenda', 'users', 'suratMasuk'));
    }
}
