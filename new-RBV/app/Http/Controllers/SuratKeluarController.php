<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\SuratKeluar;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::query();
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('tujuan', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }


        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        $suratKeluar = $query
            ->latest()
            ->paginate(10);

        return view(
            'pages.E-Office.SuratKeluar.suratkeluar',
            compact('suratKeluar')
        );
    }

    public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $suratKeluar = collect([$surat]);

        return view(
            'pages.E-Office.SuratKeluar.suratkeluar',
            compact('suratKeluar')
        );
    }

    public function create()
    {
        return view(
            'pages.E-Office.SuratKeluar.suratkeluar_create'
        );
    }

    public function store(Request $request)
    {

        $request->validate([
            'nomor_surat' => 'required|string|unique:surat_keluars,nomor_surat',
            'tanggal_keluar' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'keterangan' => 'nullable|string',
            'prioritas' => 'nullable|in:biasa,sedang,segera',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

        ]);

        $file = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan')
                ->store('surat-keluar', 'public');
        }

        SuratKeluar::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_keluar' => $request->tanggal_keluar,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'prioritas' => $request->prioritas ?? 'biasa',
            'jenis' => 'external',
            'status' => 'disetujui',
            'file_scan' => $file,
            'dibuat_oleh' => Auth::user()->id_user,

        ]);

        return redirect()
            ->route('eoffice.surat-keluar.index')
            ->with(
                'success',
                'Surat keluar berhasil dibuat.'
            );
    }

    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view(
            'pages.E-Office.SuratKeluar.suratkeluar_edit',
            compact('surat')
        );
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $request->validate([
            'nomor_surat' => 'required|string|unique:surat_keluars,nomor_surat,' . $surat->id,
            'tanggal_keluar' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'keterangan' => 'nullable|string',
            'prioritas' => 'nullable|in:biasa,sedang,segera',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $surat->file_scan;

        if ($request->hasFile('file_scan')) {
            if ($surat->file_scan) {
                Storage::disk('public')
                    ->delete($surat->file_scan);
            }

            $file = $request->file('file_scan')
                ->store('surat-keluar', 'public');

        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_keluar' => $request->tanggal_keluar,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'prioritas' => $request->prioritas ?? 'biasa',
            'file_scan' => $file,
        ]);

        return redirect()
            ->route('eoffice.surat-keluar.index')
            ->with(
                'success',
                'Surat keluar berhasil diperbarui.'
            );
    }

    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        if ($surat->file_scan) {

            Storage::disk('public')
                ->delete($surat->file_scan);
        }

        $surat->delete();

        return redirect()
            ->route('eoffice.surat-keluar.index')
            ->with(
                'success',
                'Surat keluar berhasil dihapus.'
            );
    }

    public function exportAll()
    {
        return redirect()
            ->back()
            ->with(
                'info',
                'Fitur export segera hadir.'
            );
    }

    public function pdf($id)
    {
        return redirect()
            ->back()
            ->with(
                'info',
                'Fitur PDF segera hadir.'
            );
    }
}