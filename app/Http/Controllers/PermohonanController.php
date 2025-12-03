<?php

namespace App\Http\Controllers;

use App\Models\Kenderaan;
use App\Models\MaklumatPermohonan;
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
        $kapasitiMin   = $request->kapasiti_min;
        $kapasitiMax   = $request->kapasiti_max;

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

            ->when($kapasitiMin, fn($q) =>
                $q->where('kapasiti', '>=', $kapasitiMin)
            )

            ->when($kapasitiMax, fn($q) =>
                $q->where('kapasiti', '<=', $kapasitiMax)
            )

            ->orderBy('model', 'asc')
            ->get();

        return view('user_site.halaman_utama', [
            'page'        => 'senarai',
            'kategori'    => $kategori,
            'search'      => $search,
            'jenamaList'  => $jenamaList,   // send to blade
            'kenderaan'   => $kenderaan,
        ]);
    }

    // ============================================
    // PAGE 2 : BORANG PERMOHONAN
    // ============================================
    public function borang($no_pendaftaran)
    {
        $kenderaan = Kenderaan::findOrFail($no_pendaftaran);

        return view('user_site.halaman_utama', [
            'page'      => 'borang',
            'kenderaan' => $kenderaan,
            'user'      => Auth::user(),
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

        // =======================
        // HANDLE MULTIPLE FILES
        // =======================
        $files = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran_permohonan', 'public');
                $files[] = $path;
            }
        }

        // =======================
        // SAVE TO DATABASE
        // =======================
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

}
