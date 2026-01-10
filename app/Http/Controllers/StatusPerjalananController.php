<?php

namespace App\Http\Controllers;

use App\Models\MaklumatPermohonan;
use Illuminate\Http\Request;

class StatusPerjalananController extends Controller
{
    public function index()
    {
        $senarai = MaklumatPermohonan::with('kenderaan')
            ->where('id_user', session('loginId'))
            ->where('status_pengesahan', 'Lulus')
            ->orderBy('tarikh_pelepasan', 'desc')
            ->get();

        return view('user_site.status_perjalanan', [
            'senarai' => $senarai
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'id_permohonan'       => 'required|exists:maklumat_permohonan,id_permohonan',
            'speedometer_sebelum' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'speedometer_selepas' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'ulasan'              => 'nullable|string|max:500',
        ]);

        $permohonan = MaklumatPermohonan::where('id_permohonan', $request->id_permohonan)
            ->where('id_user', session('loginId'))
            ->firstOrFail();

        $adaUpload = false;

        if ($request->hasFile('speedometer_sebelum')) {
            $permohonan->speedometer_sebelum = $request->file('speedometer_sebelum')
                ->store('speedometer/sebelum', 'public');
            $adaUpload = true;
        }

        if ($request->hasFile('speedometer_selepas')) {
            $permohonan->speedometer_selepas = $request->file('speedometer_selepas')
                ->store('speedometer/selepas', 'public');
            $adaUpload = true;
        }

        $permohonan->ulasan = $request->ulasan;

        if ($permohonan->speedometer_sebelum && $permohonan->speedometer_selepas) {
            $permohonan->status_pengesahan = 'Selesai Perjalanan';
        }

        if ($permohonan->kenderaan) {
            if ($permohonan->speedometer_sebelum && $permohonan->speedometer_selepas) {
                $permohonan->kenderaan->status_kenderaan = 'Available';
            } elseif ($adaUpload) {
                $permohonan->kenderaan->status_kenderaan = 'In Use';
            }

            $permohonan->kenderaan->save();
        }

        $permohonan->save();

        return back()->with('success', 'Maklumat perjalanan berjaya disimpan.');
    }
}