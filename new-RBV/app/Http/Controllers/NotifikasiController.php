<?php

// namespace App\Http\Controllers\EOffice;

// use App\Http\Controllers\Controller;
// use App\Models\Notifikasi;
// use Illuminate\Support\Facades\Auth;

// class NotifikasiController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();

//         $notifikasi = Notifikasi::where('id_user', $user->id_user)
//             ->orderByDesc('created_at')
//             ->limit(20)
//             ->get()
//             ->map(function ($n) {
//                 return [
//                     'id' => $n->id,
//                     'judul' => $n->judul,
//                     'pesan' => $n->pesan,
//                     'url' => $n->url,
//                     'tipe' => $n->tipe,
//                     'dibaca' => $n->dibaca,
//                     'created_at' => $n->created_at->diffForHumans(),
//                 ];
//             });

//         $belumDibaca = Notifikasi::where('id_user', $user->id_user)
//             ->where('dibaca', false)
//             ->count();

//         return response()->json([
//             'notifikasi' => $notifikasi,
//             'belum_dibaca' => $belumDibaca,
//         ]);
//     }

//     public function baca($id)
//     {
//         $notif = Notifikasi::where('id', $id)
//             ->where('id_user', Auth::user()->id_user)
//             ->firstOrFail();

//         $notif->update(['dibaca' => true]);

//         if (request()->isMethod('get')) {
//             return redirect($notif->url ?? '/eoffice/surat-masuk');
//         }

//         return response()->json(['ok' => true]);
//     }

//     public function bacaSemua()
//     {
//         Notifikasi::where('id_user', Auth::user()->id_user)
//             ->where('dibaca', false)
//             ->update(['dibaca' => true]);

//         return response()->json(['ok' => true]);
//     }
// }


namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    private function getDummyNotifikasi()
    {
        return collect([
            (object) [
                'id' => 1,
                'judul' => 'Surat Masuk Baru',
                'pesan' => 'Surat baru dari Unit Keuangan: "Pengajuan Anggaran ATK" menunggu diproses.',
                'url' => '/eoffice/surat-masuk/1',
                'tipe' => 'info',
                'dibaca' => false,
                'created_at' => Carbon::now()->subMinutes(5)->diffForHumans(),
            ],
            (object) [
                'id' => 2,
                'judul' => 'Surat Menunggu Persetujuan',
                'pesan' => 'Surat "Permohonan Kerjasama Pengadaan Alkes" menunggu persetujuan Direktur.',
                'url' => '/eoffice/surat-masuk/2',
                'tipe' => 'info',
                'dibaca' => false,
                'created_at' => Carbon::now()->subHour()->diffForHumans(),
            ],
            (object) [
                'id' => 3,
                'judul' => 'Surat Disetujui Direktur',
                'pesan' => 'Surat "Permintaan Tambahan Alat Medis ICU" disetujui Direktur, diteruskan ke Kabag.',
                'url' => '/eoffice/surat-masuk/4',
                'tipe' => 'sukses',
                'dibaca' => false,
                'created_at' => Carbon::now()->subHours(2)->diffForHumans(),
            ],
            (object) [
                'id' => 4,
                'judul' => 'Surat Di-Pending Kabag',
                'pesan' => 'Surat "Permintaan Alat Medis ICU" di-pending. Catatan: Mohon lengkapi dokumen pendukung.',
                'url' => '/eoffice/surat-masuk/4',
                'tipe' => 'peringatan',
                'dibaca' => false,
                'created_at' => Carbon::now()->subHours(3)->diffForHumans(),
            ],
            (object) [
                'id' => 5,
                'judul' => 'Kamu Di-tag dalam Surat',
                'pesan' => 'Kamu ditandai terkait surat "Klaim Pembayaran Maret 2026" oleh Direktur.',
                'url' => '/eoffice/surat-masuk/3',
                'tipe' => 'info',
                'dibaca' => true,
                'created_at' => Carbon::now()->subDay()->diffForHumans(),
            ],
            (object) [
                'id' => 6,
                'judul' => 'Surat Disetujui Sepenuhnya',
                'pesan' => 'Surat "Klaim Pembayaran Maret 2026" telah disetujui oleh Kabag.',
                'url' => '/eoffice/surat-masuk/3',
                'tipe' => 'sukses',
                'dibaca' => true,
                'created_at' => Carbon::now()->subDays(2)->diffForHumans(),
            ],
        ]);
    }

    public function index()
    {
        $semua = $this->getDummyNotifikasi();
        $belumDibaca = $semua->where('dibaca', false)->count();

        $notifikasi = $semua->map(fn ($n) => [
            'id' => $n->id,
            'judul' => $n->judul,
            'pesan' => $n->pesan,
            'url' => $n->url,
            'tipe' => $n->tipe,
            'dibaca' => $n->dibaca,
            'created_at' => $n->created_at,
        ])->values();

        return response()->json([
            'notifikasi' => $notifikasi,
            'belum_dibaca' => $belumDibaca,
        ]);
    }

    public function baca($id)
    {
        // Nanti ganti dengan:
        // $notif = Notifikasi::where('id', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();
        // $notif->update(['dibaca' => true]);

        if (request()->isMethod('get')) {
            return redirect('/eoffice/surat-masuk');
        }

        return response()->json(['ok' => true]);
    }

    public function bacaSemua()
    {
        // Nanti ganti dengan:
        // Notifikasi::where('id_user', Auth::user()->id_user)->where('dibaca', false)->update(['dibaca' => true]);
        return response()->json(['ok' => true]);
    }
}
