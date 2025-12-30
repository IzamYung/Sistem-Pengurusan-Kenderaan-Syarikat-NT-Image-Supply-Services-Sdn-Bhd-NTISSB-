<?php

namespace App\Http\Controllers;

use App\Models\MaklumatPermohonan;

class RekodPermohonanController extends Controller
{
    public function index()
    {
        $senarai = MaklumatPermohonan::with(['kenderaan'])
            ->where('id_user', session('loginId'))
            ->where('status_pengesahan', 'Selesai Perjalanan')
            ->orderBy('tarikh_mohon', 'desc')
            ->get();

        return view('user_site.rekod_permohonan', compact('senarai'));
    }
}
