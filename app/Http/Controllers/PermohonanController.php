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

        $permohonanAktif = MaklumatPermohonan::where('no_pendaftaran', $no_pendaftaran)
            ->whereIn('status_pengesahan', ['Buat Pemeriksaan', 'Menunggu Kelulusan', 'Lulus'])
            ->get();

        $bookedDates = [];

        foreach ($permohonanAktif as $p) {
            $start = Carbon::parse($p->tarikh_pelepasan)->startOfDay();
            $end = Carbon::parse($p->tarikh_pulang)->startOfDay();

            while ($start->lte($end)) {
                $bookedDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return view('user_site.halaman_utama', [
            'page'        => 'borang',
            'kenderaan'   => $kenderaan,
            'user'        => Auth::user(),
            'bookedDates' => array_unique($bookedDates),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_pendaftaran'   => 'required',
            'tarikh_pelepasan' => 'required|date',
            'tarikh_pulang'    => 'required|date|after_or_equal:tarikh_pelepasan',
            'lokasi'           => 'required|string|max:150',
            'bil_penumpang'    => 'required|integer|min:1',
            'kod_projek'       => 'required|string|max:50',
            'hak_milik'        => 'required|string|max:100',
            'lampiran.*'       => 'nullable|file|max:40960',
        ]);

        $kenderaan = Kenderaan::findOrFail($request->no_pendaftaran);
        
        if ($request->bil_penumpang > ($kenderaan->kapasiti_penumpang ?? 0)) {
            return back()->withInput()->withErrors(['bil_penumpang' => "Melebihi kapasiti kenderaan."]);
        }

        $mula   = Carbon::parse($request->tarikh_pelepasan);
        $pulang = Carbon::parse($request->tarikh_pulang);

        if ($mula->equalTo($pulang)) {
            $pulang = $mula->copy()->addMinutes(30);
        }

        $exists = MaklumatPermohonan::where('no_pendaftaran', $request->no_pendaftaran)
            ->where(function ($query) use ($mula, $pulang) {
                $query->where('tarikh_pelepasan', '<', $pulang)
                      ->where('tarikh_pulang', '>', $mula);
            })->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['tarikh_pelepasan' => 'Kenderaan telah ditempah pada tarikh/julat tersebut.']);
        }

        $files = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $files[] = $file->store('lampiran_permohonan', 'public');
            }
        }

        MaklumatPermohonan::create([
            'id_user'           => session('loginId'),
            'no_pendaftaran'    => $request->no_pendaftaran,
            'tarikh_mohon'      => now(),
            'tarikh_pelepasan'  => $request->tarikh_pelepasan,
            'tarikh_pulang'     => $request->tarikh_pulang,
            'lokasi'            => $request->lokasi,
            'bil_penumpang'     => $request->bil_penumpang,
            'kod_projek'        => $request->kod_projek,
            'hak_milik'         => $request->hak_milik,
            'lampiran'          => $files,
            'status_pengesahan' => 'Buat Pemeriksaan',
        ]);

        return redirect()->route('user_site.permohonan.index')->with('success', 'Permohonan berjaya!');
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