<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKerosakan;
use App\Models\Kenderaan;
use App\Models\MaklumatPemeriksaan;
use Carbon\Carbon;

class LaporanKerosakanController extends Controller
{
    public function index(Request $request)
    {
        $kenderaan = Kenderaan::all();

        // Kalau nak tambah laporan
        if ($request->get('action') === 'add') {
            return view('admin_site.kerosakkan_kenderaan', [
                'action' => 'add',
                'kenderaan' => $kenderaan,
                'senarai' => null,
            ]);
        }

        // List utama
        $senarai = LaporanKerosakan::with('kenderaan')
            ->where(function ($query) {
                $query->whereNull('ulasan')
                    ->orWhere('ulasan', 'not like', '%[[SELESAI]]%');
            })
            ->orderBy('tarikh_laporan', 'desc')
            ->get();

        $kerosakan = null;
        $pemeriksaan = collect();

        // Kalau ada query param ?id_kerosakan=xxx
        if ($request->has('id_kerosakan')) {
            $kerosakan = LaporanKerosakan::with('kenderaan')->find($request->id_kerosakan);

            if ($kerosakan) {
                $pemeriksaan = MaklumatPemeriksaan::where('id_permohonan', $kerosakan->id_permohonan)->get();
            }
        }

        return view('admin_site.kerosakkan_kenderaan', [
            'senarai' => $senarai,
            'kenderaan' => $kenderaan,
            'kerosakan' => $kerosakan,
            'pemeriksaan' => $pemeriksaan,
            'action' => null,
        ]);
    }

    public function store(Request $request)
    {
        // tetap sama macam awak ada
        $request->validate([
            'no_pendaftaran' => 'required|string',
            'jenis_kerosakan' => 'required|string',
            'ulasan' => 'nullable|string',
        ]);

        LaporanKerosakan::create([
            'id_permohonan' => '0',
            'no_pendaftaran' => $request->no_pendaftaran,
            'jenis_kerosakan' => $request->jenis_kerosakan,
            'ulasan' => $request->ulasan,
            'tarikh_laporan' => Carbon::now(),
        ]);

        return redirect()->route('admin_site.kerosakkan_kenderaan')->with('success', 'Laporan kerosakan berjaya ditambah.');
    }

    public function selesai(Request $request, $id)
    {
        $laporan = LaporanKerosakan::findOrFail($id);

        // Tambah [[SELESAI]] pada ulasan sedia ada
        $laporan->ulasan = ($laporan->ulasan ?? '') . ' [[SELESAI]]';
        $laporan->save();

        $kenderaan = Kenderaan::where('no_pendaftaran', $laporan->no_pendaftaran)->first();

        if ($kenderaan) {
            $kenderaan->status_kenderaan = 'Available';
            $kenderaan->save();
        }

        return redirect()->route('admin_site.kerosakkan_kenderaan')
                        ->with('success', 'Laporan ditandakan selesai.');
    }
}
