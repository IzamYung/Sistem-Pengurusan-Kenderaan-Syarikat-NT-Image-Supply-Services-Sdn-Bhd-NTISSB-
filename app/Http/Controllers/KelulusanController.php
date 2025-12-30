<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaklumatPermohonan;
use App\Models\MaklumatPemeriksaan;
use Illuminate\Support\Facades\Storage;

class KelulusanController extends Controller
{
    // ============================
    // 1. PAPAR SENARAI + MAKLUMAT
    // ============================
    public function halamanUtama(Request $request)
    {
        // Kalau admin klik satu permohonan → show detail
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

        // Else → papar senarai permohonan
        $senarai = MaklumatPermohonan::where('status_pengesahan', 'Menunggu Kelulusan')
            ->orderBy('id_permohonan', 'DESC')
            ->get();

        return view('admin_site.halaman_utama', [
            'senarai' => $senarai,
            'permohonan' => null,
            'pemeriksaan' => null
        ]);
    }

    // ============================
    // 2. LULUS PERMOHONAN
    // ============================
    public function lulus($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::findOrFail($id_permohonan);

        // 🔥 Hapus file speedometer_sebelum kalau ada
        if ($permohonan->speedometer_sebelum && Storage::disk('public')->exists($permohonan->speedometer_sebelum)) {
            Storage::disk('public')->delete($permohonan->speedometer_sebelum);
        }

        // Kosongkan column supaya blade tak preview
        $permohonan->speedometer_sebelum = null;

        // Tukar status
        $permohonan->status_pengesahan = 'Lulus';
        $permohonan->save();

        return redirect()->route('admin_site.halaman_utama')
            ->with('success', 'Permohonan diluluskan.');
    }

    // ============================
    // 3. TIDAK LULUS PERMOHONAN
    // ============================
    public function tidakLulus($id_permohonan)
    {
        $permohonan = MaklumatPermohonan::findOrFail($id_permohonan);
        $permohonan->status_pengesahan = 'Tidak Lulus';
        $permohonan->save();

        return redirect()->route('admin_site.halaman_utama')
            ->with('success', 'Permohonan ditolak.');
    }
}
