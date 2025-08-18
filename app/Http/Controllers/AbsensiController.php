<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Absensi;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Hanya tampilkan materi milik user yang login
        $materis = Materi::where('user_id', Auth::id())->latest()->paginate(10);
        return view('absensi.index', compact('materis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_rfid' => 'required|string',
            'materi_id' => 'required|exists:materis,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $materi = Materi::where('user_id', Auth::id())->findOrFail($request->materi_id);

        $peserta = Peserta::where('id_rfid', $request->id_rfid)
            ->where('user_id', Auth::id())
            ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan dengan RFID tersebut');
        }

        if ($peserta->komisi !== $materi->komisi) {
            return redirect()->back()->with('error', 'Peserta tidak terdaftar untuk materi ini');
        }

        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
            ->where('materi_id', $materi->id)
            ->exists();

        if ($existingAbsensi) {
            return redirect()->back()->with('error', 'Peserta sudah tercatat absensinya untuk materi ini');
        }

        Absensi::create([
            'user_id' => Auth::id(),
            'peserta_id' => $peserta->id,
            'materi_id' => $materi->id,
            'status' => 'hadir',
        ]);

        return redirect()->back()->with('success', "Absensi berhasil dicatat untuk {$peserta->nama} ({$peserta->asal_delegasi})");
    }

    public function scan($materiId)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($materiId);

        $peserta = Peserta::where('komisi', $materi->komisi)
            ->where('user_id', Auth::id())
            ->with(['absensi' => function ($query) use ($materiId) {
                $query->where('materi_id', $materiId);
            }])
            ->orderBy('nama')
            ->get();

        return view('absensi.scan', compact('materi', 'peserta'));
    }

    public function export($materiId)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($materiId);

        $peserta = Peserta::where('komisi', $materi->komisi)
            ->where('user_id', Auth::id())
            ->with(['absensi' => function ($query) use ($materiId) {
                $query->where('materi_id', $materiId);
            }])
            ->orderBy('nama')
            ->get();

        $currentDateTime = Carbon::now()->translatedFormat('d F Y H:i') . ' WIB';

        $pdf = Pdf::loadView('absensi.export', compact('materi', 'peserta', 'currentDateTime'));

        return $pdf->download('absensi_' . $materi->nama . '.pdf');
    }
}
