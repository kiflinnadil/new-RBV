<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('id_user', $user->id_user)
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($n) {

                return [
                    'id'         => $n->id,
                    'judul'      => $n->judul,
                    'pesan'      => $n->pesan,
                    'url'        => $n->url,
                    'tipe'       => $n->tipe,
                    'dibaca'     => $n->dibaca,
                    'created_at' => $n->created_at->diffForHumans(),
                ];

            });

        $belumDibaca = Notifikasi::where(
            'id_user',
            $user->id_user
        )
        ->where('dibaca', false)
        ->count();

        return response()->json([
            'notifikasi'   => $notifikasi,
            'belum_dibaca' => $belumDibaca,
        ]);
    }

    public function baca(Request $request, $id)
    {
        $notif = Notifikasi::where('id', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();
        $notif->update([
            'dibaca' => true
        ]);

        if ($request->isMethod('get')) {
            return redirect(
                $notif->url ?? '/eoffice/surat-masuk'
            );
        }

        return response()->json([
            'ok' => true
        ]);
    }

    public function bacaSemua()
    {
        Notifikasi::where(
            'id_user',
            Auth::user()->id_user
        )
        ->where('dibaca', false)
        ->update([
            'dibaca' => true
        ]);

        return response()->json([
            'ok' => true
        ]);
    }
}