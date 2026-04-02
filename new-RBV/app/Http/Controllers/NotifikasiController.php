<?php

namespace App\Http\Controllers\EOffice;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function index()
    {

        $notifikasi = collect([
            (object) [
                'id' => 1,
                'judul' => 'Surat Masuk Baru',
                'pesan' => 'Surat "Permohonan Kerjasama" menunggu persetujuan Anda.',
                'url' => '/eoffice/surat-masuk/1',
                'dibaca' => false,
                'created_at' => Carbon::now()->diffForHumans(),
            ],
            (object) [
                'id' => 2,
                'judul' => 'Surat Disetujui',
                'pesan' => 'Surat "Pengajuan Logistik" telah disetujui Direktur.',
                'url' => '/eoffice/surat-masuk/2',
                'dibaca' => true,
                'created_at' => Carbon::now()->subHour()->diffForHumans(),
            ],
        ]);

        return response()->json([
            'notifikasi' => $notifikasi,
            'belum_dibaca' => 1,
        ]);
    }

    public function bacaSemua()
    {
        return response()->json(['ok' => true]);
    }
}
