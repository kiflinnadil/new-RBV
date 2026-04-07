<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promkes;
use Illuminate\Http\Request;

class PromkesApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Promkes::latest()->get()
        ]);
    }

    public function show($id)
    {
        $data = Promkes::findOrFail($id);

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Promkes::create($request->all());

        return response()->json([
            'message' => 'Berhasil ditambahkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Promkes::findOrFail($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Berhasil diupdate',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        Promkes::destroy($id);

        return response()->json([
            'message' => 'Berhasil dihapus'
        ]);
    }
}