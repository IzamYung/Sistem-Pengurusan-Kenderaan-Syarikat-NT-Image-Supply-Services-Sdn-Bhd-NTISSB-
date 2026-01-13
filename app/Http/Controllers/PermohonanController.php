<?php

namespace App\Http\Controllers;

use App\Models\Kenderaan;
use App\Models\MaklumatPermohonan;
use App\Models\MaklumatPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $search   = $request->search;
        $jenama   = $request->jenama;
        $kapasiti = $request->kapasiti;

        $jenamaList = Kenderaan::selectRaw("LOWER(jenama) as jenama")
            ->groupBy('jenama')
            ->pluck('jenama')
            ->toArray();

        $kenderaan = Kenderaan::query()
            ->when($kategori, fn($q) => $q->where('jenis_kenderaan', $kategori))
            ->when($search, fn($q) => 
                $q->where(function ($x) use ($search) {
                    $x->where('model', 'LIKE', "%$search%")
                        ->orWhere('no_pendaftaran', 'LIKE', "%$search%")
                        ->orWhere('jenis_kenderaan', 'LIKE', "%$search%");
                })
            )
            ->when($jenama, fn($q) => $q->whereRaw("LOWER(jenama) = ?", [strtolower($jenama)]))
            ->when($kapasiti, fn($q) => $q->where('kapasiti_penumpang', '>=', $kapasiti))
            ->orderBy('status_kenderaan', 'asc')
            ->orderBy('model', 'asc')
            ->get();

        return view('user_site.halaman_utama', [
            'page'       => 'senarai',
            'kategori'   => $kategori,
            'search'     => $search,
            'jenamaList' => $jenamaList,
            'kenderaan'  => $kenderaan,
        ]);
    }

    public function borang($no_pendaftaran)
    {
        $kenderaan = Kenderaan::findOrFail($no_pendaftaran);

        $bookedDates = MaklumatPermohonan::where('no_pendaftaran', $no_pendaftaran)
            ->pluck('tarikh_pelepasan')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        return view('user_site.halaman_utama', [
            'page'        => 'borang',
            'kenderaan'   => $kenderaan,
            'user'        => Auth::user(),
            'bookedDates' => $bookedDates,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_pendaftaran'   => 'required',
            'tarikh_pelepasan' => 'required|date',
            'lokasi'           => 'required|string|max:150',
            'bil_penumpang'    => 'required|integer|min:1',
            'kod_projek'       => 'required|string|max:50',
            'hak_milik'        => 'required|string|max:100',
            'lampiran.*'       => 'nullable|file|max:40960',
        ]);

        $kenderaan = Kenderaan::findOrFail($request->no_pendaftaran);
        $kapasiti  = $kenderaan->kapasiti_penumpang ?? 0;

        if ($request->bil_penumpang > $kapasiti) {
            return back()->withInput()->withErrors([
                'bil_penumpang' => "Bilangan penumpang melebihi kapasiti maksimum kenderaan ($kapasiti).",
            ]);
        }

        $files = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $files[] = $file->store('lampiran_permohonan', 'public');
            }
        }

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
            'speedometer_sebelum' => null,
            'speedometer_selepas' => null,
        ]);

        return redirect()
            ->route('user_site.permohonan.index')
            ->with('success', 'Permohonan berjaya dihantar!');
    }

    public function status()
    {
        $hideAfterDays = 2;

        $permohonan = MaklumatPermohonan::where('id_user', session('loginId'))
            ->where(function ($query) use ($hideAfterDays) {
                $query->whereNotIn('status_pengesahan', ['Tidak Lulus', 'Selesai Perjalanan'])
                    ->orWhere(function ($q) use ($hideAfterDays) {
                        $q->whereIn('status_pengesahan', ['Tidak Lulus', 'Tolak'])
                            ->where('updated_at', '>=', Carbon::now()->subDays($hideAfterDays));
                    });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user_site.status_permohonan', [
            'permohonan' => $permohonan
        ]);
    }

    public function pemeriksaan($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::where('id_permohonan', $id_permohonan)
            ->where('id_user', session('loginId'))
            ->firstOrFail();

        if ($permohonan->status_pengesahan !== 'Buat Pemeriksaan') {
            return redirect()->route('user_site.status_permohonan')
                ->with('error', 'Permohonan ini tidak memerlukan pemeriksaan kenderaan lagi.');
        }

        return view('user_site.status_permohonan', [
            'page'       => 'pemeriksaan',
            'permohonan' => $permohonan,
        ]);
    }

    public function simpanPemeriksaan(Request $request)
    {
        $request->validate([
            'id_permohonan'        => 'required|exists:maklumat_permohonan,id_permohonan',
            'mileage'              => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
            'pemeriksaan.*.status' => 'required|in:1,2,3',
            'pemeriksaan.*.ulasan' => 'nullable|string|max:500',
        ]);

        $permohonan = MaklumatPermohonan::where('id_permohonan', $request->id_permohonan)
            ->where('id_user', session('loginId'))
            ->firstOrFail();

        $pathSebelum = null;
        if ($request->hasFile('mileage')) {
            $pathSebelum = $request->file('mileage')->store('speedometer/sebelum', 'public');
        }

        $permohonan->speedometer_sebelum = $pathSebelum;
        $permohonan->status_pengesahan   = 'Menunggu Kelulusan';
        $permohonan->save();

        MaklumatPemeriksaan::where('id_permohonan', $request->id_permohonan)->delete();

        $dataInsert = [];
        foreach ($request->pemeriksaan as $key => $data) {
            $dataInsert[] = [
                'id_permohonan' => $request->id_permohonan,
                'status'        => $data['status'],
                'nama_komponen' => $key,
                'ulasan'        => $data['ulasan'] ?? null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        MaklumatPemeriksaan::insert($dataInsert);

        return redirect()->route('user_site.status_permohonan')
            ->with('success', 'Pemeriksaan berjaya dihantar. Permohonan kini Menunggu Kelulusan.');
    }
}