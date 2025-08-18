@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Compact Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="ri-user-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Data Peserta</h1>
                            <p class="text-gray-600 text-sm">Data peserta untuk sistem absensi</p>
                        </div>
                    </div>
                    <a href="{{ route('peserta.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl px-5 py-3 font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-md">
                        <i class="ri-add-line text-lg"></i>
                        <span>Tambah Data Peserta</span>
                    </a>
                </div>
            </div>

            <!-- Participant Data -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Peserta Terdaftar</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('peserta.export') }}" class="flex items-center px-3 py-1.5 text-sm bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">
                                <i class="ri-download-line w-4 h-4 mr-1"></i>
                                Export
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200/50">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Kartu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal Delegasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="peserta-table" class="bg-white/60 divide-y divide-gray-200/50">
                            @foreach ($peserta as $index => $p)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        {{ ($peserta->currentPage() - 1) * $peserta->perPage() + $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">{{ $p->id_rfid }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->asal_delegasi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeColor =
                                                [
                                                    'organisasi' => 'bg-green-100 text-green-800',
                                                    'program-kerja' => 'bg-blue-100 text-blue-800',
                                                    'rekomendasi' => 'bg-purple-100 text-purple-800',
                                                ][$p->komisi] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                            {{ ucfirst(str_replace('-', ' ', $p->komisi)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $p->jenis_kelamin }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $p->created_at->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('peserta.edit', $p->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="ri-edit-line w-4 h-4 inline"></i>
                                        </a>
                                        <form action="{{ route('peserta.destroy', $p->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 cursor-pointer"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')">
                                                <i class="ri-delete-bin-line w-4 h-4 inline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($peserta->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200/50 bg-gray-50/80">
                        {{ $peserta->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
