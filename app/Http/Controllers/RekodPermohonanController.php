<?php

namespace App\Http\Controllers;

use App\Models\MaklumatPermohonan;

class RekodPermohonanController extends Controller
{
    public function index()
    {
        $query = MaklumatPermohonan::with(['kenderaan', 'user'])
            ->whereIn('status_pengesahan', [
                'Selesai Perjalanan',
                'Tidak Lulus',
            ])
            ->orderBy('tarikh_mohon', 'desc');

        if (session('role') !== 'admin') {
            $query->where('id_user', session('loginId'));
        }

        $senarai = $query->get();

        if (session('role') === 'admin') {
            return view('admin_site.rekod_permohonan', compact('senarai'));
        }

        return view('user_site.rekod_permohonan', compact('senarai'));
    }
}