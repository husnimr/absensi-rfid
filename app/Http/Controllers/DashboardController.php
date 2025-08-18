<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Materi;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistik jumlah data milik user
        $totalPeserta = Peserta::where('user_id', $userId)->count();
        $totalMateri = Materi::where('user_id', $userId)->count();
        $totalAbsensi = Absensi::where('user_id', $userId)->count();

        // Data absensi terbaru milik user
        $recentAttendance = Absensi::with(['peserta', 'materi'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Statistik komisi hanya untuk user terkait
        $statsKomisi = [
            'organisasi' => Peserta::where('user_id', $userId)->where('komisi', 'organisasi')->count(),
            'program-kerja' => Peserta::where('user_id', $userId)->where('komisi', 'program-kerja')->count(),
            'rekomendasi' => Peserta::where('user_id', $userId)->where('komisi', 'rekomendasi')->count(),
        ];

        // Data untuk chart berdasarkan materi yang dimiliki user
        $attendanceByMateri = Absensi::select(
                'materis.nama as materi_nama',
                DB::raw('COUNT(absensi.id) as total_kehadiran')
            )
            ->join('materis', 'absensi.materi_id', '=', 'materis.id')
            ->where('absensi.user_id', $userId)
            ->where('absensi.status', 'Hadir')
            ->groupBy('materis.nama')
            ->orderBy('materis.nama')
            ->get();

        $chartData = [];
        $chartLabels = [];

        foreach ($attendanceByMateri as $materi) {
            $chartLabels[] = $materi->materi_nama;
            $chartData[] = $materi->total_kehadiran;
        }

        return view('dashboard', compact(
            'totalPeserta',
            'totalMateri',
            'totalAbsensi',
            'recentAttendance',
            'statsKomisi',
            'chartLabels',
            'chartData'
        ));
    }
}
