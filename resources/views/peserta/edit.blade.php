@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="ri-edit-box-line text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Edit Data Peserta</h1>
                        <p class="text-gray-600 text-sm">Perbarui informasi peserta dan kartu RFID untuk sistem absensi</p>
                    </div>
                </div>
            </div>

            <!-- Form Edit Peserta -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-6 mb-8">
                <form id="editPesertaForm" action="{{ route('peserta.update', $peserta->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="id_rfid" class="block text-sm font-medium text-gray-700 mb-2">
                                ID Kartu RFID
                            </label>
                            <div class="relative">
                                <input type="text" id="id_rfid" name="id_rfid" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Tap kartu RFID atau masukkan ID manual"
                                    value="{{ old('id_rfid', $peserta->id_rfid) }}"
                                    onkeydown="return event.key !== 'Enter';">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="ri-sd-card-line w-5 h-5 text-gray-400"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Tempelkan kartu RFID pada reader atau masukkan ID secara manual
                            </p>
                            @error('id_rfid')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" id="nama" name="nama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('nama', $peserta->nama) }}">
                            @error('nama')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="asal_delegasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Asal Delegasi
                            </label>
                            <input type="text" id="asal_delegasi" name="asal_delegasi" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Contoh: Pac Magetan"
                                value="{{ old('asal_delegasi', $peserta->asal_delegasi) }}">
                            @error('asal_delegasi')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="komisi" class="block text-sm font-medium text-gray-700 mb-2">
                                Komisi
                            </label>
                            <select id="komisi" name="komisi" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Komisi</option>
                                <option value="organisasi" {{ old('komisi', $peserta->komisi) == 'organisasi' ? 'selected' : '' }}>Organisasi</option>
                                <option value="program-kerja" {{ old('komisi', $peserta->komisi) == 'program-kerja' ? 'selected' : '' }}>Program Kerja</option>
                                <option value="rekomendasi" {{ old('komisi', $peserta->komisi) == 'rekomendasi' ? 'selected' : '' }}>Rekomendasi</option>
                            </select>
                            @error('komisi')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('peserta.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-colors">
                            <i class="ri-close-line w-4 h-4 inline mr-1"></i>
                            Batal
                        </a>
                        <button type="submit" id="submitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer shadow-sm transition-all">
                            <i class="ri-save-line w-4 h-4 inline mr-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rfidInput = document.getElementById('id_rfid');
            const form = document.getElementById('editPesertaForm');

            // Mencegah form submit saat menekan Enter di input RFID
            rfidInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    return false;
                }
            });

            // Jika card reader mengirimkan data dengan karakter khusus di akhir
            rfidInput.addEventListener('input', function(e) {
                // Bersihkan input dari karakter tambahan (jika ada)
                this.value = this.value.replace(/[^0-9a-fA-F]/g, '');
            });

            // Alternatif: Jika card reader mengirimkan Enter setelah data
            rfidInput.addEventListener('change', function() {
                // Hilangkan karakter newline atau carriage return
                this.value = this.value.replace(/\r?\n|\r/g, '');

                // Fokus ke field berikutnya (nama) setelah scan selesai
                document.getElementById('nama').focus();
            });
        });
    </script>
@endsection
