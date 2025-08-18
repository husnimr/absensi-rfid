<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::where('user_id', Auth::id())->orderBy('nama')->get();
        return view('materi.index', compact('materis'));
    }

    public function create()
    {
        $komisiList = Materi::getKomisiList();
        return view('materi.create', compact('komisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komisi' => 'required|in:organisasi,program-kerja,rekomendasi',
        ]);

        Materi::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'komisi' => $request->komisi,
        ]);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);
        return view('materi.show', compact('materi'));
    }

    public function edit($id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);
        $komisiList = Materi::getKomisiList();
        return view('materi.edit', compact('materi', 'komisiList'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komisi' => 'required|in:organisasi,program-kerja,rekomendasi',
        ]);

        $materi->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'komisi' => $request->komisi,
        ]);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);
        $materi->delete();
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
