<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $peserta = Peserta::where('user_id', Auth::id())->orderBy('nama')->paginate(20);
        return view('peserta.index', compact('peserta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peserta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rfid' => 'required|unique:peserta',
            'nama' => 'required',
            'asal_delegasi' => 'required',
            'komisi' => 'required|in:organisasi,program-kerja,rekomendasi',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        Peserta::create([
            'user_id' =>Auth::id(),
            'id_rfid' => $request->id_rfid,
            'nama' => $request->nama,
            'asal_delegasi' => $request->asal_delegasi,
            'komisi' => $request->komisi,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);
        return view('peserta.edit', compact('peserta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'id_rfid' => 'required|unique:peserta,id_rfid,' . $id,
            'nama' => 'required',
            'asal_delegasi' => 'required',
            'komisi' => 'required|in:organisasi,program-kerja,rekomendasi',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $peserta->update([
            'id_rfid' => $request->id_rfid,
            'nama' => $request->nama,
            'asal_delegasi' => $request->asal_delegasi,
            'komisi' => $request->komisi,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }

    /**
     * Export the peserta data to PDF.
     */
    public function export()
    {
        $peserta = Peserta::where('user_id', Auth::id())->orderBy('nama')->get();
        $currentDateTime = Carbon::now()->translatedFormat('d F Y H:i') . ' WIB';

        $pdf = Pdf::loadView('peserta.export', compact('peserta', 'currentDateTime'));
        return $pdf->download('daftar_peserta.pdf');
    }
}
