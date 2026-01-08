<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaklumatPermohonan;
use App\Models\MaklumatPemeriksaan;
use App\Models\LaporanKerosakan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KelulusanController extends Controller
{
    public function halamanUtama(Request $request)
    {
        if ($request->has('id_permohonan')) {

            $permohonan = MaklumatPermohonan::find($request->id_permohonan);
            if (!$permohonan) {
                return redirect()->route('admin_site.halaman_utama')
                    ->with('error', 'Permohonan tidak dijumpai.');
            }

            $pemeriksaan = MaklumatPemeriksaan::where('id_permohonan', $request->id_permohonan)->get();

            return view('admin_site.halaman_utama', [
                'permohonan' => $permohonan,
                'pemeriksaan' => $pemeriksaan,
                'senarai' => null
            ]);
        }

        $senarai = MaklumatPermohonan::where('status_pengesahan', 'Menunggu Kelulusan')
            ->orderBy('id_permohonan', 'DESC')
            ->get();

        return view('admin_site.halaman_utama', [
            'senarai' => $senarai,
            'permohonan' => null,
            'pemeriksaan' => null
        ]);
    }

    public function lulus($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::findOrFail($id_permohonan);

        if ($permohonan->speedometer_sebelum &&
            Storage::disk('public')->exists($permohonan->speedometer_sebelum)) {
            Storage::disk('public')->delete($permohonan->speedometer_sebelum);
        }

        $permohonan->speedometer_sebelum = null;
        $permohonan->status_pengesahan = 'Lulus';
        $permohonan->save();

        return redirect()->route('admin_site.halaman_utama')
            ->with('success', 'Permohonan diluluskan.');
    }

    public function tidakLulus($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::findOrFail($id_permohonan);
        $permohonan->status_pengesahan = 'Tidak Lulus';
        $permohonan->save();

        return redirect()->route('admin_site.halaman_utama')
            ->with('success', 'Permohonan ditolak.');
    }

    public function tidakLulusRosak($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::findOrFail($id_permohonan);

        $permohonan->status_pengesahan = 'Tidak Lulus';
        $permohonan->save();

        // Ambik pemeriksaan
        $pemeriksaan = MaklumatPemeriksaan::where('id_permohonan', $id_permohonan)->get();

        $ulasanRingkas = $pemeriksaan->map(function($item) {
            if ($item->status == 2) return $item->nama_komponen . " memerlukan pemerhatian";
            if ($item->status == 3) return $item->nama_komponen . " memerlukan pemerhatian segera";
        })->filter()->implode(', '); // join semua ayat jadi satu string

        LaporanKerosakan::create([
            'no_pendaftaran' => $permohonan->no_pendaftaran,
            'tarikh_laporan' => Carbon::today(),
            'jenis_kerosakan' => 'Kerosakan pada bahagian kenderaan',
            'ulasan' => $ulasanRingkas,
        ]);

        return redirect()->route('admin_site.halaman_utama')
            ->with('success', 'Permohonan ditolak & laporan kerosakan direkodkan.');
    }
}
