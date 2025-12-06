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

}
