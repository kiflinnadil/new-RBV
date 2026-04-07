<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Panduan::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $panduans = $query->latest()->paginate(10);

        return view('pages.Layanan.panduan,pedoman dan SOP.panduan', compact('panduans'));
    }

    public function create()
    {
        return view('pages.Layanan.panduan,pedoman dan SOP.panduancreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:20480',
        ]);

        $file = $request->file('file')->store('panduan', 'public');

        Panduan::create([
            'judul' => $request->judul,
            'file' => $file,
        ]);

        return redirect()->route('panduan.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $panduan = Panduan::findOrFail($id);

        return view('pages.Layanan.panduan,pedoman dan SOP.panduanedit', compact('panduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $panduan = Panduan::findOrFail($id);

        $data = [
            'judul' => $request->judul,
        ];

        if ($request->file('file')) {
            Storage::disk('public')->delete($panduan->file);
            $data['file'] = $request->file('file')->store('panduan', 'public');
        }

        $panduan->update($data);

        return redirect()->route('panduan.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $panduan = Panduan::findOrFail($id);

        Storage::disk('public')->delete($panduan->file);
        $panduan->delete();

        return redirect()->route('panduan.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}