@extends('layouts.app')

@section('title', 'Input Pemeriksaan')
@section('header', '📋 Input Pemeriksaan Balita')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('pemeriksaan.store') }}" method="POST" id="formPemeriksaan">
            @csrf

            <!-- ========================================== -->
            <!-- 1. DATA BALITA                              -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">👶 Pilih Balita</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Balita <span class="text-red-500">*</span></label>
                    <select name="balita_id" id="balita_id" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('balita_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Balita --</option>
                        @foreach($balitas as $b)
                            <option value="{{ $b->id }}" 
                                    data-umur="{{ $b->tanggal_lahir->diffInMonths(now()) }}"
                                    data-jk="{{ $b->jenis_kelamin }}"
                                    data-nama="{{ $b->nama_balita }}"
                                    {{ (isset($balita) && $balita->id == $b->id) || old('balita_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_balita }} ({{ $b->tanggal_lahir->diffInMonths(now()) }} bulan) - {{ $b->jenis_kelamin }}
                            </option>
                        @endforeach
                    </select>
                    @error('balita_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                    <!-- Informasi Balita -->
                    <div id="infoBalita" class="bg-gray-50 p-3 rounded-lg {{ isset($balita) ? '' : 'hidden' }}">
                        <p class="text-sm"><strong>Nama:</strong> <span id="nama_display">{{ $balita->nama_balita ?? '-' }}</span></p>
                        <p class="text-sm"><strong>Umur:</strong> <span id="umur_display">{{ isset($balita) ? $balita->tanggal_lahir->diffInMonths(now()) : '-' }}</span> bulan</p>
                        <p class="text-sm"><strong>Jenis Kelamin:</strong> <span id="jk_display">{{ $balita->jenis_kelamin ?? '-' }}</span></p>
                    </div>
                </div>
            </div>

            <hr class="my-6">

            <!-- ========================================== -->
            <!-- 2. DATA ANTROPOMETRI                        -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">📏 Data Antropometri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('tanggal') border-red-500 @enderror" required>
                        @error('tanggal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cara Ukur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cara Ukur</label>
                        <select name="cara_ukur" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih --</option>
                            <option value="Berdiri" {{ old('cara_ukur') == 'Berdiri' ? 'selected' : '' }}>Berdiri</option>
                            <option value="Berbaring" {{ old('cara_ukur') == 'Berbaring' ? 'selected' : '' }}>Berbaring</option>
                        </select>
                    </div>

                    <!-- Berat Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berat Badan (kg) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="berat_badan" id="berat" 
                               value="{{ old('berat_badan') }}" 
                               placeholder="Contoh: 12.5" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('berat_badan') border-red-500 @enderror" required>
                        @error('berat_badan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tinggi Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi" 
                               value="{{ old('tinggi_badan') }}" 
                               placeholder="Contoh: 85.5" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('tinggi_badan') border-red-500 @enderror" required>
                        @error('tinggi_badan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Lingkar Kepala -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lingkar Kepala (cm)</label>
                        <input type="number" step="0.1" name="lingkar_kepala" 
                               value="{{ old('lingkar_kepala') }}" 
                               placeholder="Contoh: 45.0" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Lingkar Lengan (LiLA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lingkar Lengan (cm)</label>
                        <input type="number" step="0.1" name="lingkar_lengan" 
                               value="{{ old('lingkar_lengan') }}" 
                               placeholder="Contoh: 16.0" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 3. HASIL DETEKSI OTOMATIS                   -->
            <!-- ========================================== -->
            <div id="hasilDeteksi" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg hidden">
                <h3 class="font-bold text-lg text-gray-800">🔬 Hasil Analisis Otomatis</h3>
                <div id="statusDetail" class="mt-3 text-center p-3 rounded">
                    <span class="text-sm text-gray-500">Silakan isi data dan pilih anak untuk mendeteksi.</span>
                </div>
            </div>

            <hr class="my-6">

            <!-- ========================================== -->
            <!-- 4. PELAYANAN KESEHATAN                      -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">💉 Pelayanan Kesehatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- ASI Eksklusif -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ASI Eksklusif</label>
                        <select name="asi_eksklusif" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('asi_eksklusif') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('asi_eksklusif') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <!-- Vitamin A -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vitamin A</label>
                        <input type="text" name="vitamin_a" value="{{ old('vitamin_a') }}" 
                               placeholder="Contoh: Biru / Merah" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Obat Cacing -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Obat Cacing</label>
                        <input type="text" name="obat_cacing" value="{{ old('obat_cacing') }}" 
                               placeholder="Contoh: Albendazole 400 mg" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- MT Pemulihan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">MT Pemulihan</label>
                        <select name="mt_pemulihan" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('mt_pemulihan') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('mt_pemulihan') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <!-- Penyuluhan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penyuluhan</label>
                        <select name="penyuluhan" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('penyuluhan') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('penyuluhan') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <!-- Topik Penyuluhan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Topik Penyuluhan</label>
                        <input type="text" name="topik_penyuluhan" value="{{ old('topik_penyuluhan') }}" 
                               placeholder="Contoh: Gizi seimbang" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Rujukan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rujukan</label>
                        <input type="text" name="rujukan" value="{{ old('rujukan') }}" 
                               placeholder="Contoh: Puskesmas X" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}" 
                               placeholder="Catatan tambahan" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <hr class="my-6">

            <!-- ========================================== -->
            <!-- 5. IMUNISASI                                -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">💉 Imunisasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Imunisasi</label>
                        <input type="text" name="jenis_imunisasi" value="{{ old('jenis_imunisasi') }}" 
                               placeholder="Contoh: BCG, DPT, Polio, Campak" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Imunisasi</label>
                        <input type="date" name="tanggal_imunisasi" value="{{ old('tanggal_imunisasi', date('Y-m-d')) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Keterangan Imunisasi</label>
                        <input type="text" name="keterangan_imunisasi" value="{{ old('keterangan_imunisasi') }}" 
                               placeholder="Catatan imunisasi" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <hr class="my-6">

            <!-- ========================================== -->
            <!-- 6. CATATAN                                 -->
            <!-- ========================================== -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">📝 Catatan / Keluhan / Saran</label>
                <textarea name="catatan" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="Tuliskan catatan penting...">{{ old('catatan') }}</textarea>
            </div>

            <!-- ========================================== -->
            <!-- 7. TOMBOL                                  -->
            <!-- ========================================== -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 shadow">
                    <i class="fas fa-save"></i> Simpan Pemeriksaan
                </button>
                <a href="{{ route('dashboard') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2.5 rounded-lg transition shadow">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="reset" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2.5 rounded-lg transition shadow">
                    <i class="fas fa-undo"></i> Reset Form
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // ELEMEN DOM
    // ==========================================
    const balitaSelect = document.getElementById('balita_id');
    const beratInput = document.getElementById('berat');
    const tinggiInput = document.getElementById('tinggi');
    const hasilDiv = document.getElementById('hasilDeteksi');
    const statusDetail = document.getElementById('statusDetail');
    const infoBalita = document.getElementById('infoBalita');

    // ==========================================
    // UPDATE INFO BALITA
    // ==========================================
    balitaSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            infoBalita.classList.remove('hidden');
            document.getElementById('nama_display').textContent = selected.dataset.nama || '-';
            document.getElementById('umur_display').textContent = selected.dataset.umur || '-';
            document.getElementById('jk_display').textContent = selected.dataset.jk || '-';
        } else {
            infoBalita.classList.add('hidden');
        }
        doDetection();
    });

    // ==========================================
    // DETEKSI OTOMATIS (AJAX)
    // ==========================================
    function doDetection() {
        const balitaId = balitaSelect.value;
        const berat = parseFloat(beratInput.value);
        const tinggi = parseFloat(tinggiInput.value);

        if (!balitaId || isNaN(berat) || isNaN(tinggi) || berat <= 0 || tinggi <= 0) {
            hasilDiv.classList.add('hidden');
            return;
        }

        hasilDiv.classList.remove('hidden');
        statusDetail.innerHTML = '<span class="text-gray-500">⏳ Menganalisis data...</span>';

        fetch('{{ route("pemeriksaan.detect") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                balita_id: balitaId,
                berat: berat,
                tinggi: tinggi
            })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            // Tentukan warna berdasarkan status
            let bgColor = 'bg-green-100 text-green-800';
            let icon = '✅';
            let statusText = data.status_stunting ?? data.status_gizi ?? 'Normal';

            if (data.status_stunting === 'Severely Stunted' || data.status_stunting === 'Stunted') {
                bgColor = 'bg-red-100 text-red-800';
                icon = '🚨';
            } else if (data.status_gizi === 'Wasting' || data.status_gizi === 'Severely Wasted') {
                bgColor = 'bg-orange-100 text-orange-800';
                icon = '⚠️';
            } else if (data.status_gizi === 'Underweight' || data.status_gizi === 'Severely Underweight') {
                bgColor = 'bg-yellow-100 text-yellow-800';
                icon = '⚠️';
            } else if (data.status_gizi === 'Overweight' || data.status_gizi === 'Obese' || data.status_gizi === 'Overweight / Obese') {
                bgColor = 'bg-purple-100 text-purple-800';
                icon = '⚠️';
            } else if (data.status_gizi === 'Normal' && data.status_stunting === 'Normal') {
                bgColor = 'bg-green-100 text-green-800';
                icon = '✅';
            }

            statusDetail.innerHTML = `
                <div class="${bgColor} p-4 rounded-lg">
                    <p class="font-bold text-lg">${icon} Status Gizi: <span class="uppercase">${data.status_gizi ?? 'N/A'}</span></p>
                    <p class="font-bold">Status Stunting: <span class="uppercase">${data.status_stunting ?? 'N/A'}</span></p>
                    <p class="text-sm mt-1">${data.message ?? ''}</p>
                    <p class="text-xs mt-2 border-t pt-2 border-gray-200">
                        Z-Score TB/U: <strong>${data.z_tb ?? 'N/A'}</strong> | 
                        Z-Score BB/U: <strong>${data.z_bb ?? 'N/A'}</strong>
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        💡 Keterangan: 
                        <span class="text-red-600">Merah = Stunting</span> | 
                        <span class="text-yellow-600">Kuning = Underweight</span> | 
                        <span class="text-orange-600">Oranye = Wasting</span> | 
                        <span class="text-green-600">Hijau = Normal</span>
                    </p>
                </div>
            `;
        })
        .catch(err => {
            statusDetail.innerHTML = `
                <div class="bg-red-50 border border-red-200 p-3 rounded text-red-600">
                    <p>❌ Terjadi kesalahan koneksi.</p>
                    <p class="text-xs">${err.message}</p>
                </div>
            `;
            console.error('Error:', err);
        });
    }

    // ==========================================
    // EVENT LISTENERS
    // ==========================================
    beratInput.addEventListener('input', doDetection);
    tinggiInput.addEventListener('input', doDetection);

    // Trigger awal jika ada data
    if (balitaSelect.value && beratInput.value && tinggiInput.value) {
        doDetection();
    }

    // ==========================================
    // VALIDASI FORM SEBELUM SUBMIT
    // ==========================================
    document.getElementById('formPemeriksaan').addEventListener('submit', function(e) {
        const balitaId = balitaSelect.value;
        const berat = parseFloat(beratInput.value);
        const tinggi = parseFloat(tinggiInput.value);

        if (!balitaId) {
            e.preventDefault();
            alert('Silakan pilih balita terlebih dahulu.');
            return false;
        }

        if (isNaN(berat) || berat <= 0) {
            e.preventDefault();
            alert('Silakan isi berat badan dengan benar.');
            return false;
        }

        if (isNaN(tinggi) || tinggi <= 0) {
            e.preventDefault();
            alert('Silakan isi tinggi badan dengan benar.');
            return false;
        }

        return true;
    });
});
</script>
@endpush
@endsection