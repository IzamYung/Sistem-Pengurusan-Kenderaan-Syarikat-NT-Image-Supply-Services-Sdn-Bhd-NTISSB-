<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKerosakan;
use App\Models\Kenderaan;
use Carbon\Carbon;

class LaporanKerosakanController extends Controller
{
    public function index(Request $request)
    {
        // ambil semua kenderaan untuk select box
        $kenderaan = Kenderaan::all();

        if ($request->get('action') === 'add') {
            // show form tambah laporan
            return view('admin_site.kerosakkan_kenderaan', [
                'action' => 'add',
                'kenderaan' => $kenderaan,
                'senarai' => null
            ]);
        }

        // default senarai laporan
        $senarai = LaporanKerosakan::with('kenderaan')
            ->where(function($query) {
                $query->whereNull('ulasan')
                    ->orWhere('ulasan', 'not like', '%[[SELESAI]]%');
            })
            ->orderBy('tarikh_laporan', 'desc')
            ->get();

        return view('admin_site.kerosakkan_kenderaan', [
            'senarai' => $senarai,
            'kenderaan' => $kenderaan,
            'action' => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_pendaftaran' => 'required|exists:kenderaan,no_pendaftaran',
            'jenis_kerosakan' => 'required|string',
            'ulasan' => 'nullable|string',
        ]);

        $kenderaan = Kenderaan::where('no_pendaftaran', $request->no_pendaftaran)->first();

        LaporanKerosakan::create([
            'no_pendaftaran' => $kenderaan->no_pendaftaran,
            'tarikh_laporan' => Carbon::today(),
            'jenis_kerosakan' => $request->jenis_kerosakan,
            'ulasan' => $request->ulasan ?? '',
        ]);

        return redirect()->route('admin_site.kerosakkan_kenderaan')
            ->with('success', 'Laporan kerosakan berjaya ditambah.');
    }

    public function selesai($id)
    {
        $laporan = LaporanKerosakan::findOrFail($id);

        if ($laporan->ulasan) {
            $laporan->ulasan .= ' [[SELESAI]]'; // tambah tag khas
        } else {
            $laporan->ulasan = '[[SELESAI]]';
        }

        $laporan->save();

         $kenderaan = Kenderaan::where('no_pendaftaran', $laporan->no_pendaftaran)->first();

        if ($kenderaan) {
            $kenderaan->status_kenderaan = 'Available';
            $kenderaan->save();
        }

        return redirect()->route('admin_site.kerosakkan_kenderaan')
            ->with('success', 'Laporan kerosakan ditandai Selesai.');
    }
}
