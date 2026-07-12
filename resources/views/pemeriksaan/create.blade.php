@extends('layouts.app')

@section('title', 'Input Pemeriksaan')
@section('header', '📋 Input Pemeriksaan')

@section('content')
<div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

    <!-- === CARD UTAMA === -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        @if(session('success'))
            <div class="mb-4 bg-pink-100/80 backdrop-blur-sm border-l-4 border-pink-500 text-pink-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-pink-500 text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100/80 backdrop-blur-sm border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('pemeriksaan.store') }}" method="POST" id="formPemeriksaan">
            @csrf

            <!-- ========================================== -->
            <!-- 1. INFORMASI BALITA                         -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-pink-600 mb-3">👶 Informasi Balita</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">PILIH BALITA <span class="text-red-500">*</span></label>
                        <select name="balita_id" id="balita_id"
                                class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('balita_id') border-red-500 @else border-gray-300 @enderror" required>
                            <option value="">-- Pilih Balita --</option>
                            @foreach($balitas as $b)
                                <option value="{{ $b->id }}"
                                        data-umur="{{ $b->tanggal_lahir->diffInMonths(now()) }}"
                                        data-jk="{{ $b->jenis_kelamin }}"
                                        data-nama="{{ $b->nama_balita }}"
                                        data-nik="{{ $b->nik }}"
                                        {{ (isset($balita) && $balita->id == $b->id) || old('balita_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_balita }} ({{ $b->tanggal_lahir->diffInMonths(now()) }} bulan) - {{ $b->jenis_kelamin }}
                                </option>
                            @endforeach
                        </select>
                        @error('balita_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">TANGGAL PEMERIKSAAN <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('tanggal') border-red-500 @else border-gray-300 @enderror" required>
                        @error('tanggal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Informasi tambahan (muncul setelah balita dipilih) -->
                <div id="infoBalita" class="mt-3 bg-white/30 backdrop-blur-sm border border-white/30 rounded-xl p-3 {{ isset($balita) ? '' : 'hidden' }}">
                    <p class="text-sm"><strong>Nama:</strong> <span id="nama_display">{{ $balita->nama_balita ?? '-' }}</span></p>
                    <p class="text-sm"><strong>NIK:</strong> <span id="nik_display">{{ $balita->nik ?? '-' }}</span></p>
                    <p class="text-sm"><strong>Umur:</strong> <span id="umur_display">{{ isset($balita) ? $balita->tanggal_lahir->diffInMonths(now()) : '-' }}</span> bulan</p>
                    <p class="text-sm"><strong>Jenis Kelamin:</strong> <span id="jk_display">{{ $balita->jenis_kelamin ?? '-' }}</span></p>
                </div>
            </div>

            <hr class="border-white/30 my-6">

            <!-- ========================================== -->
            <!-- 2. DATA PENGUKURAN                          -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-pink-600 mb-3">📏 Data Pengukuran</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Berat Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berat Badan (KG) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="berat_badan" id="berat"
                               value="{{ old('berat_badan') }}"
                               placeholder="0.0"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('berat_badan') border-red-500 @else border-gray-300 @enderror" required>
                        <span class="text-xs text-gray-400">kilogram</span>
                        @error('berat_badan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tinggi Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggi Badan (CM) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi"
                               value="{{ old('tinggi_badan') }}"
                               placeholder="0.0"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('tinggi_badan') border-red-500 @else border-gray-300 @enderror" required>
                        <span class="text-xs text-gray-400">centimeter</span>
                        @error('tinggi_badan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Lingkar Kepala -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lingkar Kepala (CM)</label>
                        <input type="number" step="0.1" name="lingkar_kepala"
                               value="{{ old('lingkar_kepala') }}"
                               placeholder="0.0"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <span class="text-xs text-gray-400">centimeter</span>
                    </div>

                    <!-- Lingkar Lengan (LiLA) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">LILA (CM)</label>
                        <input type="number" step="0.1" name="lingkar_lengan"
                               value="{{ old('lingkar_lengan') }}"
                               placeholder="0.0"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <span class="text-xs text-gray-400">centimeter</span>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 3. HASIL DETEKSI OTOMATIS (AJAX)           -->
            <!-- ========================================== -->
            <div id="loadingIndicator" class="hidden items-center gap-3 text-gray-500 mt-2">
                @include('partials.loading-spinner')
                <span class="text-sm font-medium text-pink-500">Menganalisis data...</span>
            </div>

            <div id="hasilDeteksi" class="mt-4 p-4 bg-white/30 backdrop-blur-sm border border-white/30 rounded-xl hidden">
                <h3 class="font-bold text-lg text-pink-600">🔬 Hasil Analisis Otomatis</h3>
                <div id="statusDetail" class="mt-3 text-center p-3 rounded-lg">
                    <span class="text-sm text-gray-500">Silakan isi data dan pilih anak untuk mendeteksi.</span>
                </div>
            </div>

            <hr class="border-white/30 my-6">

            <!-- ========================================== -->
            <!-- 4. TAMBAHAN (Vitamin, Obat, Imunisasi)      -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-pink-600 mb-3">💊 Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Vitamin A -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vitamin A</label>
                        <input type="text" name="vitamin_a" value="{{ old('vitamin_a') }}"
                               placeholder="Contoh: Biru / Merah"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <span class="text-xs text-gray-400">Suplemen bulan Februari/Agustus</span>
                    </div>

                    <!-- Obat Cacing -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Obat Cacing</label>
                        <input type="text" name="obat_cacing" value="{{ old('obat_cacing') }}"
                               placeholder="Contoh: Albendazole 400 mg"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <span class="text-xs text-gray-400">Diberikan setiap 6 bulan</span>
                    </div>

                    <!-- Imunisasi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Imunisasi</label>
                        <input type="text" name="jenis_imunisasi" value="{{ old('jenis_imunisasi') }}"
                               placeholder="Contoh: BCG, DPT, Polio, Campak"
                               class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                        <span class="text-xs text-gray-400">Lengkapi jadwal imunisasi rutin</span>
                    </div>
                </div>
            </div>

            <hr class="border-white/30 my-6">

            <!-- ========================================== -->
            <!-- 5. CATATAN TAMBAHAN                         -->
            <!-- ========================================== -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">📝 Catatan Tambahan</label>
                <textarea name="catatan" rows="3" class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition" placeholder="Tuliskan keluhan ibu, saran bidan, atau kondisi khusus balita di sini...">{{ old('catatan') }}</textarea>
            </div>

            <!-- ========================================== -->
            <!-- 6. TIPS KADER & BANTUAN                    -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-xl p-4">
                    <h4 class="font-semibold text-pink-600 text-sm">💡 Tips Kader:</h4>
                    <p class="text-sm text-gray-700 mt-1">Pastikan balita sudah sarapan sebelum diberikan Obat Cacing untuk menghindari mual.</p>
                </div>
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-xl p-4">
                    <h4 class="font-semibold text-pink-600 text-sm">📞 Butuh Bantuan?</h4>
                    <p class="text-sm text-gray-700 mt-1">Hubungi tim IT Dinkes untuk akses tambahan.</p>
                    <p class="text-sm text-pink-500 font-medium mt-1">Kontak Support</p>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 7. TOMBOL                                  -->
            <!-- ========================================== -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data Pemeriksaan
                </button>
                <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-6 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
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
    const loadingIndicator = document.getElementById('loadingIndicator');

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
            document.getElementById('nik_display').textContent = selected.dataset.nik || '-';
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
            loadingIndicator.classList.add('hidden');
            loadingIndicator.classList.remove('flex');
            return;
        }

        // Tampilkan loading
        loadingIndicator.classList.remove('hidden');
        loadingIndicator.classList.add('flex');
        hasilDiv.classList.add('hidden');

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
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            // Sembunyikan loading
            loadingIndicator.classList.add('hidden');
            loadingIndicator.classList.remove('flex');
            hasilDiv.classList.remove('hidden');

            let bgColor = 'bg-green-100 text-green-800';
            let icon = '✅';
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
            loadingIndicator.classList.add('hidden');
            loadingIndicator.classList.remove('flex');
            hasilDiv.classList.remove('hidden');
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