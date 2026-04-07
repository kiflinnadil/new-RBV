<?php

namespace App\Http\Controllers;

use App\Models\Promkes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromkesController extends Controller
{
    public function index(Request $request)
    {
        $query = Promkes::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $promkes = $query->latest()->paginate(10);

        return view('pages.Layanan.promkes.promkes', compact('promkes'));
    }

    public function create()
    {
        return view('pages.Layanan.promkes.promkescreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('promkes', 'public');
        }

        Promkes::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'file' => $filePath
        ]);

        return redirect()->route('promkes.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $promkes = Promkes::findOrFail($id);
        return view('pages.Layanan.promkes.promkesedit', compact('promkes'));
    }

    public function update(Request $request, $id)
    {
        $promkes = Promkes::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
        ];

        if ($request->hasFile('file')) {
            if ($promkes->file) {
                Storage::disk('public')->delete($promkes->file);
            }

            $data['file'] = $request->file('file')->store('promkes', 'public');
        }

        $promkes->update($data);

        return redirect()->route('promkes.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $promkes = Promkes::findOrFail($id);

        if ($promkes->file) {
            Storage::disk('public')->delete($promkes->file);
        }

        $promkes->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}