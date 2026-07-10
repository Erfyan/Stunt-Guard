<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Pemeriksaan;
use App\Models\PelayananKesehatan;
use App\Models\Imunisasi;
use App\Services\StuntingDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    protected $detection;

    /**
     * Constructor: inject service deteksi stunting
     */
    public function __construct(StuntingDetectionService $detection)
    {
        $this->detection = $detection;
    }

    /**
     * Tampilkan form input pemeriksaan
     */
    public function create(Balita $balita = null)
    {
        $user = Auth::user();

        // Ambil data balita berdasarkan role
        if ($user->role == 'Kader') {
            // Jika Kader punya posyandu_id, filter, jika tidak tampilkan semua
            if ($user->posyandu_id) {
                $balitas = Balita::where('posyandu_id', $user->posyandu_id)->get();
            } else {
                // Sementara tampilkan semua (atau bisa kosong)
                $balitas = Balita::all();
            }
        } else {
            // Admin atau lainnya melihat semua
            $balitas = Balita::all();
        }

        return view('pemeriksaan.create', compact('balitas', 'balita'));
    }

    /**
     * Simpan data pemeriksaan
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'balita_id' => 'required|exists:balitas,id',
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric|min:0.1',
            'tinggi_badan' => 'required|numeric|min:1',
            'lingkar_kepala' => 'nullable|numeric|min:1',
            'lingkar_lengan' => 'nullable|numeric|min:1',
            'cara_ukur' => 'nullable|string|max:50',
            'catatan' => 'nullable|string',
            // Pelayanan
            'asi_eksklusif' => 'nullable|in:Ya,Tidak',
            'vitamin_a' => 'nullable|string',
            'obat_cacing' => 'nullable|string',
            'mt_pemulihan' => 'nullable|in:Ya,Tidak',
            'penyuluhan' => 'nullable|in:Ya,Tidak',
            'topik_penyuluhan' => 'nullable|string',
            'rujukan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            // Imunisasi
            'jenis_imunisasi' => 'nullable|string',
            'tanggal_imunisasi' => 'nullable|date',
            'keterangan_imunisasi' => 'nullable|string',
        ]);

        $balita = Balita::findOrFail($request->balita_id);

        // Hitung umur dalam bulan
        $umurBulan = Carbon::parse($balita->tanggal_lahir)->diffInMonths(now());

        // Analisis stunting
        $result = $this->detection->analyze(
            $request->berat_badan,
            $request->tinggi_badan,
            $umurBulan,
            $balita->jenis_kelamin
        );

                // Simpan pemeriksaan
        $pemeriksaan = Pemeriksaan::create([
            'balita_id' => $request->balita_id,
            'tanggal' => $request->tanggal,
            'umur_bulan' => $umurBulan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'lingkar_kepala' => $request->lingkar_kepala,
            'lingkar_lengan' => $request->lingkar_lengan,
            'cara_ukur' => $request->cara_ukur,
            'zscore' => $result['z_tb'] ?? null,
            'status_gizi' => $result['status_gizi'],
            'status_stunting' => $result['status_stunting'],
            'bb_tidak_nak' => $result['bb_tidak_nak'] ?? 'Tidak',
            'catatan' => $request->catatan,
            'petugas' => Auth::user()->nama,   // tetap pakai petugas (string)
            // 'created_by' => Auth::id(),     // komentar atau hapus
        ]);
        // Simpan pelayanan kesehatan
        $pelayanan = null;
        if ($request->asi_eksklusif || $request->vitamin_a || $request->obat_cacing ||
            $request->mt_pemulihan || $request->penyuluhan || $request->rujukan) {
            $pelayanan = PelayananKesehatan::create([
                'pemeriksaan_id' => $pemeriksaan->id,
                'asi_eksklusif' => $request->asi_eksklusif,
                'vitamin_a' => $request->vitamin_a,
                'obat_cacing' => $request->obat_cacing,
                'mt_pemulihan' => $request->mt_pemulihan,
                'penyuluhan' => $request->penyuluhan,
                'topik_penyuluhan' => $request->topik_penyuluhan,
                'rujukan' => $request->rujukan,
                'keterangan' => $request->keterangan,
            ]);
        }

        // Simpan imunisasi (jika ada pelayanan dan jenis imunisasi diisi)
        if ($pelayanan && $request->jenis_imunisasi) {
            Imunisasi::create([
                'pelayanan_id' => $pelayanan->id,
                'jenis_imunisasi' => $request->jenis_imunisasi,
                'tanggal' => $request->tanggal_imunisasi ?? $request->tanggal,
                'keterangan' => $request->keterangan_imunisasi,
            ]);
        }

        return redirect()->route('balita.show', $balita->id)
            ->with('success', 'Pemeriksaan berhasil disimpan! Status: ' . $result['status_gizi']);
    }

    /**
     * API deteksi real-time via AJAX
     */
    public function detect(Request $request)
    {
        $balita = Balita::findOrFail($request->balita_id);
        $umurBulan = Carbon::parse($balita->tanggal_lahir)->diffInMonths(now());

        $result = $this->detection->analyze(
            $request->berat,
            $request->tinggi,
            $umurBulan,
            $balita->jenis_kelamin
        );

        return response()->json($result);
    }
}