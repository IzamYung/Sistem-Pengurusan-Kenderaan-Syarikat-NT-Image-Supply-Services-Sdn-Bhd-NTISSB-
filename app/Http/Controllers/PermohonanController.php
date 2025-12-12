<?php

namespace App\Http\Controllers;

use App\Models\Kenderaan;
use App\Models\MaklumatPermohonan;
use App\Models\MaklumatPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    // ============================================
    // PAGE 1 : SENARAI KENDERAAN (LIST + FILTER)
    // ============================================
    public function index(Request $request)
    {
        $kategori      = $request->kategori;
        $search        = $request->search;
        $jenama        = $request->jenama;

        // ❌ kapasiti_min & kapasiti_max removed (unused)
        // ❌ filter kapasiti removed (incorrect column name and not used)

        // Fetch all jenama (unique, lowercase-insensitive)
        $jenamaList = Kenderaan::selectRaw("LOWER(jenama) as jenama")
                        ->groupBy('jenama')
                        ->pluck('jenama')
                        ->toArray();

        $kenderaan = Kenderaan::query()

            ->when($kategori, fn($q) =>
                $q->where('jenis_kenderaan', $kategori)
            )

            ->when($search, fn($q) =>
                $q->where(function($x) use ($search){
                    $x->where('model', 'LIKE', "%$search%")
                    ->orWhere('no_pendaftaran', 'LIKE', "%$search%");
                })
            )

            ->when($jenama, fn($q) =>
                $q->whereRaw("LOWER(jenama) = ?", [strtolower($jenama)])
            )

            ->orderBy('model', 'asc')
            ->get();

        return view('user_site.halaman_utama', [
            'page'        => 'senarai',
            'kategori'    => $kategori,
            'search'      => $search,
            'jenamaList'  => $jenamaList,
            'kenderaan'   => $kenderaan,
        ]);
    }

    // ============================================
    // PAGE 2 : BORANG PERMOHONAN
    // ============================================
    public function borang($no_pendaftaran)
    {
        $kenderaan = Kenderaan::findOrFail($no_pendaftaran);
        $bookedDates = MaklumatPermohonan::where('no_pendaftaran', $no_pendaftaran)
            ->pluck('tarikh_pelepasan')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        return view('user_site.halaman_utama', [
            'page'      => 'borang',
            'kenderaan' => $kenderaan,
            'user'      => Auth::user(),
            'bookedDates' => $bookedDates,
        ]);
    }

    // ============================================
    // STORE PERMOHONAN (SAVE)
    // ============================================
    public function store(Request $request)
    {
        $request->validate([
            'no_pendaftaran'  => 'required',
            'tarikh_pelepasan'=> 'required|date',
            'lokasi'          => 'required|string|max:150',
            'bil_penumpang'   => 'required|integer|min:1',
            'kod_projek'      => 'required|string|max:50',
            'hak_milik'       => 'required|string|max:100',
            'lampiran.*'      => 'nullable|file|max:4096',
        ]);

        $kenderaan = Kenderaan::findOrFail($request->no_pendaftaran);
        $kapasiti = $kenderaan->kapasiti_penumpang ?? 0;

        if ($request->bil_penumpang > $kapasiti) {
            return back()
                ->withInput()
                ->withErrors([
                    'bil_penumpang' => "Bilangan penumpang melebihi kapasiti maksimum kenderaan ($kapasiti).",
                ]);
        }

        $files = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran_permohonan', 'public');
                $files[] = $path;
            }
        }

        // Check if vehicle already booked for selected date
        $exists = MaklumatPermohonan::where('no_pendaftaran', $request->no_pendaftaran)
                    ->whereDate('tarikh_pelepasan', date('Y-m-d', strtotime($request->tarikh_pelepasan)))
                    ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'tarikh_pelepasan' => 'Kereta ini telah ditempah pada tarikh ini.',
            ]);
        }

        MaklumatPermohonan::create([
            'id_user'             => session('loginId'),
            'no_pendaftaran'      => $request->no_pendaftaran,
            'tarikh_mohon'        => now(), 
            'tarikh_pelepasan'    => $request->tarikh_pelepasan,
            'lokasi'              => $request->lokasi,
            'bil_penumpang'       => $request->bil_penumpang,
            'kod_projek'          => $request->kod_projek,
            'hak_milik'           => $request->hak_milik,
            'lampiran'            => $files,
            'status_pengesahan'   => 'Buat Pemeriksaan',
            'speedometer_sebelum' => 0,
            'speedometer_selepas' => null,
        ]);

        return redirect()
            ->route('user_site.permohonan.index')
            ->with('success', 'Permohonan berjaya dihantar!');
    }

    // ============================================
    // PAGE 3 : STATUS PERMOHONAN / REKOD
    // ============================================
    public function status()
    {
        $permohonan = MaklumatPermohonan::where('id_user', session('loginId'))
                        ->orderBy('tarikh_mohon', 'desc')
                        ->get();

        return view('user_site.status_permohonan', [
            'permohonan' => $permohonan
        ]);
    }

    // Dalam app/Http/Controllers/PermohonanController.php

    // Tambah method untuk memaparkan Borang Pemeriksaan
    public function pemeriksaan($id_permohonan)
    {
        // Cari permohonan berdasarkan ID dan pengguna yang sedang log masuk
        $permohonan = MaklumatPermohonan::where('id_permohonan', $id_permohonan)
            ->where('id_user', session('loginId'))
            ->firstOrFail();
        
        // Pastikan status adalah 'Buat Pemeriksaan' sebelum membenarkan pemeriksaan
        if ($permohonan->status_pengesahan !== 'Buat Pemeriksaan') {
            // Redirect atau berikan mesej ralat jika tidak boleh diperiksa
            return redirect()->route('user_site.status_permohonan')
                ->with('error', 'Permohonan ini tidak memerlukan pemeriksaan kenderaan lagi.');
        }

        return view('user_site.status_permohonan', [
            'page' => 'pemeriksaan', // Pembolehubah untuk switch view
            'permohonan' => $permohonan,
        ]);
    }

    // Tambah method untuk menyimpan Borang Pemeriksaan
    public function simpanPemeriksaan(Request $request)
    {
        // 1. Validation (Anda boleh tambah lebih banyak validation)
        $request->validate([
            'id_permohonan'       => 'required|exists:maklumat_permohonan,id_permohonan',
            'mileage'             => 'required|numeric|min:0',
            'pemeriksaan.*.status' => 'required|in:1,2,3',
            'pemeriksaan.*.ulasan' => 'nullable|string|max:500', // Hanya diperlukan jika status 2/3
        ]);

        $id_permohonan = $request->id_permohonan;

        // 2. Fetch Permohonan
        $permohonan = MaklumatPermohonan::where('id_permohonan', $id_permohonan)
            ->where('id_user', session('loginId'))
            ->firstOrFail();

        // 3. Simpan Mileage
        $permohonan->speedometer_sebelum = $request->mileage;
        $permohonan->status_pengesahan = 'Menunggu Kelulusan'; // Kemaskini status selepas pemeriksaan
        $permohonan->save();
        
        // 4. Simpan Butiran Pemeriksaan
        // Hapus rekod pemeriksaan lama berdasarkan id_permohonan
        MaklumatPemeriksaan::where('id_permohonan', $id_permohonan)->delete();

        // Simpan data pemeriksaan
        $pemeriksaanData = [];
        $failedCheck = false;
        $componentList = [
            'badan_luaran' => 'Badan Luaran Kenderaan',
            'cermin_hadapan' => 'Cermin Hadapan / Sisi',
            'pengelap_cermin' => 'Pengelap Cermin',
            'brek' => 'Brek (Pad / Kasut Brek)',
            'salur_hos_brek' => 'Salur & Hos Brek',
            'sistem_stereng' => 'Sistem Stereng',
        ];
        
        foreach ($request->pemeriksaan as $key => $data) {
            $status = $data['status'];
            $ulasan = $data['ulasan'] ?? null;
            
            // Cek jika status 2 atau 3, wajib ada ulasan (penjelasan)
            if (in_array($status, ['2', '3']) && empty($ulasan)) {
                return back()->withInput()->withErrors([
                    "pemeriksaan.$key.ulasan" => "Penjelasan diperlukan jika status adalah 2 atau 3 untuk " . ($componentList[$key] ?? $key) . "."
                ]);
            }

            if (in_array($status, ['2', '3'])) {
                $failedCheck = true; // Set flag jika ada kerosakan
            }
            
            $pemeriksaanData[] = [
                // PERUBAHAN UTAMA: Gunakan id_permohonan di sini
                'id_permohonan'  => $id_permohonan, 
                // Lajur 'no_pendaftaran' telah DIBUANG dari array data kerana ia dikeluarkan dari migration
                'kategori'       => 'Pemeriksaan Sebelum', 
                'nama_komponen'  => $componentList[$key] ?? $key,
                'status'         => $status,
                'ulasan'         => $ulasan,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }
        
        // Simpan semua rekod pemeriksaan dalam satu masa
        if (!empty($pemeriksaanData)) {
            MaklumatPemeriksaan::insert($pemeriksaanData);
        }
        
        // Tentukan mesej berdasarkan status pemeriksaan
        $message = $failedCheck ? 
            'Pemeriksaan berjaya dihantar. Terdapat isu yang memerlukan perhatian. Permohonan anda kini Menunggu Kelulusan.' :
            'Pemeriksaan kenderaan berjaya dihantar. Permohonan anda kini Menunggu Kelulusan.';

        return redirect()->route('user_site.status_permohonan')
            ->with('success', $message);
    }

}