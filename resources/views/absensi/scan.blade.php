@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Compact Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="ri-rfid-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Scan Absensi RFID</h1>
                            <p class="text-gray-600 text-sm">Tempelkan kartu RFID</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-4 text-white min-w-[250px]">
                        <div class="text-sm font-bold opacity-90 text-center">{{ $materi->nama }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Compact RFID Scanning Area -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-3 text-center">Area Pemindaian</h2>

                        <!-- Compact Scan Zone -->
                        <div
                            class="relative bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border-2 border-dashed border-gray-300 hover:border-blue-400 transition-all duration-300">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="relative">
                                    <div class="absolute inset-0 w-16 h-16 bg-blue-400/20 rounded-full animate-ping"></div>
                                    <div
                                        class="relative w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="ri-rfid-line text-2xl text-white"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-lg font-bold text-gray-900">Siap Memindai</h3>
                                    <p class="text-gray-600 text-sm">Tempelkan kartu RFID</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-gray-600">Aktif</span>
                                </div>
                            </div>
                        </div>

                        <!-- Compact Summary Stats -->
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            @php
                                $total = count($peserta);
                                $hadir = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return $attendance && $attendance->status === 'hadir';
                                    })
                                    ->count();
                                $terlambat = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return $attendance && $attendance->status === 'terlambat';
                                    })
                                    ->count();
                                $belum_absen = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return !$attendance || $attendance->status === 'belum_absen';
                                    })
                                    ->count();
                            @endphp

                            <div class="bg-gray-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-gray-900">{{ $total }}</div>
                                <div class="text-xs text-gray-600">Total</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-green-600">{{ $hadir }}</div>
                                <div class="text-xs text-gray-600">Hadir</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-yellow-600">{{ $terlambat }}</div>
                                <div class="text-xs text-gray-600">Terlambat</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-gray-500">{{ $belum_absen }}</div>
                                <div class="text-xs text-gray-600">Belum</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compact Attendance Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200/50 bg-gradient-to-r from-gray-50 to-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Kehadiran</h3>
                        </div>

                        <div class="overflow-x-auto max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">No
                                        </th>

                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">RFID
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">Nama
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">
                                            Delegasi</th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">Status
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($peserta as $index => $p)
                                        @php
                                            $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                            $status = $attendance ? $attendance->status : 'belum_absen';
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                            <td class="py-2 px-3 text-xs text-gray-900">{{ $index + 1 }}</td>
                                            <td class="py-2 px-3 text-xs font-mono text-gray-900 bg-gray-50/30 rounded">
                                                {{ $p->id_rfid }}</td>
                                            <td class="py-2 px-3 text-xs font-medium text-gray-900">{{ $p->nama }}</td>
                                            <td class="py-2 px-3 text-xs text-gray-500">{{ $p->asal_delegasi }}</td>
                                            <td class="py-2 px-3 text-xs">
                                                <span
                                                    class="px-2 py-1 inline-flex items-center text-xs leading-4 font-semibold rounded-full
                                                @if ($status === 'hadir') bg-green-100 text-green-800
                                                @elseif($status === 'terlambat') bg-yellow-100 text-yellow-800
                                                @elseif($status === 'tidak_hadir') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                    @if ($status === 'hadir')
                                                        <i class="ri-check-line mr-1"></i>Hadir
                                                    @elseif($status === 'terlambat')
                                                        <i class="ri-time-line mr-1"></i>Terlambat
                                                    @elseif($status === 'tidak_hadir')
                                                        <i class="ri-close-line mr-1"></i>Tidak Hadir
                                                    @else
                                                        <i class="ri-question-line mr-1"></i>Belum
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 text-xs">
                                                @if ($attendance)
                                                    <!-- Tombol Reset -->
                                                    <form action="{{ route('absensi.reset', ['materi' => $materi->id, 'peserta' => $p->id]) }}" 
                                                        method="POST" id="resetForm-{{ $p->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="openResetModal({{ $p->id }})"
                                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 hover:bg-red-200">
                                                            <i class="ri-refresh-line mr-1"></i>
                                                        </button>
                                                    </form>

                                                @else
                                                    <span class="text-gray-400 italic">-</span>
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Modal Konfirmasi Reset -->
            <div id="resetModal-{{ $p->id }}"
                class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
                <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl transform animate-bounce">
                    <div class="text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-red-400 to-rose-500 mb-4">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Konfirmasi Reset</h3>
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl mb-4">
                            Apakah kamu yakin ingin mereset absensi <b>{{ $p->nama }}</b> ke <b>Belum Absen</b>?
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="closeResetModal({{ $p->id }})"
                                class="w-1/2 bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-xl hover:bg-gray-300 transition-all duration-300">
                                Batal
                            </button>
                            <button type="button" onclick="confirmReset({{ $p->id }})"
                                class="w-1/2 bg-gray-200 text-red-800 font-semibold py-2 px-4 rounded-xl hover:bg-red-300 transition-all duration-300">
                                Ya, Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Status Modal -->
            @if (session('success') || session('error'))
                <div id="statusModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl transform animate-bounce">
                        <div class="text-center">
                            @if (session('success'))
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 mb-4">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Absensi Berhasil!</h3>
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-red-400 to-rose-500 mb-4">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Absensi Gagal!</h3>
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <button type="button" onclick="closeModal()"
                                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hidden Form -->
            <form method="POST" action="{{ route('absensi.store') }}" id="rfid_form"
                style="opacity: 0; position: absolute; left: -9999px;">
                @csrf
                <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                <input type="text" id="rfid_input" name="id_rfid" 
                    style="position:absolute; left:0; top:0; width:1px; height:1px; opacity:0;"
                    required autocomplete="off">
                <button type="submit" id="hidden_submit"></button>
            </form>

            <!-- Visual Feedback -->
            <div id="scan_feedback"
                class="fixed inset-0 flex items-center justify-center z-40 bg-black/50 backdrop-blur-sm hidden">
                <div class="bg-white rounded-2xl p-6 max-w-xs w-full mx-4 shadow-2xl">
                    <div class="text-center">
                        <div class="relative w-16 h-16 mx-auto mb-4">
                            <div class="absolute inset-0 bg-blue-400/20 rounded-full animate-ping"></div>
                            <div
                                class="relative w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <i class="ri-loader-4-line text-2xl text-white animate-spin"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Memproses...</h3>
                        <p class="text-gray-600 text-sm">Sedang memproses kartu RFID</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                transform: translate3d(0, -15px, 0);
            }

            70% {
                transform: translate3d(0, -7px, 0);
            }

            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .animate-bounce {
            animation: bounce 0.6s ease-in-out;
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rfidInput = document.getElementById('rfid_input');
        const scanFeedback = document.getElementById('scan_feedback');
        const rfidForm = document.getElementById('rfid_form');

        // Fokus awal
        rfidInput.focus();

        function handleRfidScan(value) {
            if (value.length >= 8) {
                rfidInput.value = value; // pastikan isi
                rfidForm.submit();
            }
            scanFeedback.classList.remove('hidden'); // Tampilkan feedback
        }

        // Listener saat ada input masuk dari reader
        rfidInput.addEventListener('input', function(e) {
            handleRfidScan(e.target.value);
        });

        // Auto-reset input setelah submit
        rfidForm.addEventListener("submit", function() {
            setInterval(() => rfidInput.focus(), 500);
        });

        // Kalau kehilangan fokus, balikin lagi
        rfidInput.addEventListener("blur", function() {
            setTimeout(() => rfidInput.focus(), 100);
        });

        // Bersihkan saat reload halaman
        window.addEventListener('beforeunload', function() {
            rfidInput.value = '';
        });
    });

    @if (session('success') || session('error'))
        setTimeout(() => {
            closeModal();
        }, 2000);

        function closeModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }
    @endif
</script>

<script>
    function openResetModal(pesertaId, nama) {
        document.getElementById('resetModal-' + pesertaId).classList.remove('hidden');
    }

    function closeResetModal(pesertaId) {
        document.getElementById('resetModal-' + pesertaId).classList.add('hidden');
    }

    function confirmReset(pesertaId) {
        document.getElementById('resetForm-' + pesertaId).submit();
    }
</script>



@endsection
