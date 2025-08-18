@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Compact Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="ri-file-list-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Data Materi</h1>
                            <p class="text-gray-600 text-sm">Daftar materi untuk sistem absensi</p>
                        </div>
                    </div>
                    <a href="" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl px-5 py-3 font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-md">

                        <span>Sistem Absensi</span>
                    </a>
                </div>
            </div>

            <!-- Materials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($materis as $materi)
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 border-b border-gray-200/50">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $materi->nama }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($materi->komisi === 'organisasi') bg-green-100 text-green-800
                                    @elseif($materi->komisi === 'program-kerja') bg-blue-100 text-blue-800
                                    @elseif($materi->komisi === 'rekomendasi') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('-', ' ', $materi->komisi)) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mb-4">{{ $materi->deskripsi }}</p>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="ri-calendar-line w-5 h-5 mr-2 text-blue-500"></i>
                                <span>Dibuat: {{ $materi->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <a href="{{ route('absensi.scan', $materi->id) }}"
                                   class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                    <i class="ri-qr-scan-line"></i>
                                    <span>Scan Absensi</span>
                                </a>

                                <a href="{{ route('absensi.export', $materi->id) }}"
                                   class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                    <i class="ri-download-line"></i>
                                    <span>Export Absensi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if(count($materis) === 0)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-folder-info-line text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data materi</h3>
                    <p class="text-gray-600 mb-4">Silakan tambahkan data materi baru</p>
                    <a href="{{ route('materi.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all">
                        <i class="ri-add-line mr-2"></i> Tambah Materi
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if ($materis->hasPages())
                <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4">
                    {{ $materis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
