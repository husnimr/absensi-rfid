@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Dashboard Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="ri-dashboard-line text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Selamat Datang di Dashboard Admin</h1>
                        <p class="text-gray-600">Kelola sistem absensi RFID dengan mudah dan efisien</p>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Peserta -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                        <i class="ri-user-line text-xl text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Peserta</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalPeserta ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Total Materi -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                        <i class="ri-book-line text-xl text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Materi</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalMateri ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Total Absensi -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                        <i class="ri-file-list-line text-xl text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Absensi</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalAbsensi ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quick Access & Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Quick Access -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Akses Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('peserta.create') }}"
                            class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="w-8 h-8 rounded-md bg-blue-500 flex items-center justify-center mr-3">
                                <i class="ri-user-add-line text-white"></i>
                            </div>
                            <span class="text-sm font-medium">Tambah Peserta Baru</span>
                        </a>
                        <a href="{{ route('materi.create') }}"
                            class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="w-8 h-8 rounded-md bg-purple-500 flex items-center justify-center mr-3">
                                <i class="ri-book-line text-xl text-white"></i>
                            </div>
                            <span class="text-sm font-medium">Tambah Materi Baru</span>
                        </a>
                        <a href="{{ route('absensi.index') }}"
                            class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="w-8 h-8 rounded-md bg-green-500 flex items-center justify-center mr-3">
                                <i class="ri-qr-scan-line text-white"></i>
                            </div>
                            <span class="text-sm font-medium">Scan Absensi</span>
                        </a>
                        <a href=""
                            class="flex items-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <div class="w-8 h-8 rounded-md bg-orange-500 flex items-center justify-center mr-3">
                                <i class="ri-file-download-line text-white"></i>
                            </div>
                            <span class="text-sm font-medium">Export Semua Data</span>
                        </a>
                    </div>
                </div>

                <!-- Attendance Chart -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Kehadiran</h3>
                    <div class="h-64 flex items-center justify-center" id="attendance-chart">
                        <canvas id="attendanceStatsChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Committee Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activity -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                        <a href="{{ route('absensi.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat
                            Semua</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Materi</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Asal Delegasi</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/60 divide-y divide-gray-200">
                                @forelse ($recentAttendance ?? [] as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attendance->peserta->nama }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            {{ $attendance->materi->nama }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attendance->peserta->asal_delegasi }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if ($attendance->status === 'hadir')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            @elseif ($attendance->status === 'tidak_hadir')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                    {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attendance->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">Belum ada
                                            data absensi terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Committee Stats -->
                @php
                    // Hindari pembagian dengan 0
                    $totalPesertaFix = max(1, (int) ($totalPeserta ?? 0));

                    $persenOrganisasi = (($totalAbsensi ?? 0) / $totalPesertaFix) * 100;
                    $persenProgramKerja = (($statsKomisi['program-kerja'] ?? 0) / $totalPesertaFix) * 100;
                    $persenRekomendasi = (($statsKomisi['rekomendasi'] ?? 0) / $totalPesertaFix) * 100;
                @endphp

                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-5 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Komisi</h3>

                    <div class="space-y-4">
                        <!-- Organisasi -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Organisasi</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $statsKomisi['organisasi'] ?? 0 }} Peserta
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ number_format($persenOrganisasi, 2) }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Program Kerja -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Program Kerja</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $statsKomisi['program-kerja'] ?? 0 }} Peserta
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full"
                                    style="width: {{ number_format($persenProgramKerja, 2) }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Rekomendasi -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Rekomendasi</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $statsKomisi['rekomendasi'] ?? 0 }} Peserta
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full"
                                    style="width: {{ number_format($persenRekomendasi, 2) }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceStatsChart').getContext('2d');

            const attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels ?? ['Belum ada data materi']) !!},
                    datasets: [{
                        label: 'Jumlah Kehadiran per Materi',
                        data: {!! json_encode($chartData ?? [0]) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Kehadiran per Materi'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
