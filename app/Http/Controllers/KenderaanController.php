<?php

namespace App\Http\Controllers;

use App\Models\Kenderaan;
use Illuminate\Http\Request;

class KenderaanController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $kenderaan = Kenderaan::when($query, function ($q) use ($query) {
                $q->where('no_pendaftaran', 'like', "%{$query}%")
                  ->orWhere('jenama', 'like', "%{$query}%")
                  ->orWhere('model', 'like', "%{$query}%");
            })
            ->orderBy('no_pendaftaran', 'asc')
            ->paginate(10);

        return view('admin_site.senarai_kenderaan', [
            'kenderaan' => $kenderaan,
            'editKenderaan' => null,
            'tambahMode' => false
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $kenderaan = Kenderaan::when($query, function ($q) use ($query) {
                $q->where('no_pendaftaran', 'like', "%{$query}%")
                  ->orWhere('jenama', 'like', "%{$query}%")
                  ->orWhere('model', 'like', "%{$query}%");
            })
            ->get();

        return response()->json($kenderaan);
    }

    public function create()
    {
        return view('admin_site.senarai_kenderaan', [
            'kenderaan' => [],
            'editKenderaan' => null,
            'tambahMode' => true
        ]);
    }

    public function edit($no_pendaftaran)
    {
        $allKenderaan = Kenderaan::all();
        $editKenderaan = Kenderaan::findOrFail($no_pendaftaran);

        return view('admin_site.senarai_kenderaan', [
            'kenderaan' => $allKenderaan,
            'editKenderaan' => $editKenderaan,
            'tambahMode' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_pendaftaran' => 'required|unique:kenderaan,no_pendaftaran',
            'gambar_kenderaan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'jenis_kenderaan' => 'required|string|max:50',
            'jenama' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'warna' => 'required|string|max:30',
            'kapasiti_penumpang' => 'required|integer|min:1',
            'tarikh_mula_roadtax' => 'required|date',
            'tarikh_tamat_roadtax' => 'required|date|after_or_equal:tarikh_mula_roadtax',
            'status_kenderaan' => 'required|string|max:20',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar_kenderaan')) {
            $file = $request->file('gambar_kenderaan');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/kenderaan'), $filename);
            $validated['gambar_kenderaan'] = 'images/kenderaan/' . $filename;
        } else {
            $validated['gambar_kenderaan'] = 'images/kenderaan/default-vehicle.png';
        }

        Kenderaan::create($validated);

        return redirect()->route('admin_site.senarai_kenderaan')
            ->with('success', 'Kenderaan baru berjaya ditambah!');
    }

    public function update(Request $request, $no_pendaftaran)
    {
        $kend = Kenderaan::findOrFail($no_pendaftaran);

        $validated = $request->validate([
            'no_pendaftaran' => 'required|unique:kenderaan,no_pendaftaran,' . $no_pendaftaran . ',no_pendaftaran',
            'gambar_kenderaan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'jenis_kenderaan' => 'required|string|max:50',
            'jenama' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'warna' => 'required|string|max:30',
            'kapasiti_penumpang' => 'required|integer|min:1',
            'tarikh_mula_roadtax' => 'required|date',
            'tarikh_tamat_roadtax' => 'required|date|after_or_equal:tarikh_mula_roadtax',
            'status_kenderaan' => 'required|string|max:20',
        ]);

        // Tukar gambar baru
        if ($request->hasFile('gambar_kenderaan')) {
            // buang gambar lama
            if ($kend->gambar_kenderaan &&
                file_exists(public_path($kend->gambar_kenderaan)) &&
                $kend->gambar_kenderaan != 'images/kenderaan/default-vehicle.png') {

                unlink(public_path($kend->gambar_kenderaan));
            }

            $file = $request->file('gambar_kenderaan');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/kenderaan'), $filename);
            $validated['gambar_kenderaan'] = 'images/kenderaan/' . $filename;
        }

        // Handle tukar ID (no pendaftaran)
        $newId = $validated['no_pendaftaran'];
        unset($validated['no_pendaftaran']);

        $kend->update($validated);

        // update primary key
        $kend->no_pendaftaran = $newId;
        $kend->save();

        return redirect()->route('admin_site.senarai_kenderaan')
            ->with('success', 'Maklumat kenderaan dikemas kini!');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Tiada kenderaan dipilih'], 400);
        }

        Kenderaan::whereIn('no_pendaftaran', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Kenderaan berjaya dipadam']);
    }
}
