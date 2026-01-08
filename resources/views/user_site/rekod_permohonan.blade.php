@extends('user_site.layout.layout')

@section('title', 'Rekod Permohonan')

@section('content')
<h1 class="text-3xl font-bold text-center mt-20 mb-8 text-blue-900">
    Rekod Permohonan
</h1>

{{-- FILTER STATUS --}}
<div class="flex justify-end mb-4 w-full max-w-5xl mx-auto">
    <select id="filterPermohonan" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Rekod</option>
        <option value="selesai">Lulus</option>
        <option value="tidak_lulus">Tidak Lulus</option>
    </select>
</div>

<div class="flex flex-col items-center max-w-5xl mx-auto">

    @foreach ($senarai as $item)
    <div
        data-status="{{ $item->status_pengesahan === 'Tidak Lulus' ? 'tidak_lulus' : 'selesai' }}"
        data-modal-open="modalPermohonan"
        data-no="{{ $item->no_pendaftaran }}"
        data-model="{{ $item->kenderaan->model ?? '-' }}"
        data-tarikh="{{ $item->tarikh_pelepasan }}"
        data-lokasi="{{ $item->lokasi }}"
        data-bil="{{ $item->bil_penumpang }}"
        data-kod="{{ $item->kod_projek }}"
        data-hak="{{ $item->hak_milik }}"
        data-lampiran="{{ json_encode($item->lampiran ?? []) }}"
        class="permohonan-card bg-white shadow-md rounded-xl p-5 mb-4 border hover:shadow-lg transition cursor-pointer w-full"
    >
        <div class="flex justify-between mb-3">
            <div class="text-sm text-gray-600 space-y-1">
                <p>Nombor Pendaftaran: <span class="font-medium">{{ $item->no_pendaftaran }}</span></p>
                <p>Model: <span class="font-medium">{{ $item->kenderaan->model ?? '-' }}</span></p>
                <p>Lokasi: <span class="font-medium">{{ $item->lokasi ?? '-' }}</span></p>
            </div>
            <div class="text-right text-sm text-gray-500">
                <p>Tarikh Mohon</p>
                <p class="font-medium text-gray-700">{{ $item->tarikh_mohon }}</p>
            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- ================= MODAL ================= --}}
<div id="modalPermohonan" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">

    <div data-modal-card class="bg-white w-full max-w-3xl rounded-xl shadow-lg transform scale-95 opacity-0 transition-all duration-200 p-8">

        <h2 class="text-xl font-bold text-center mb-6">
            MAKLUMAT PERMOHONAN KENDERAAN
        </h2>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <p class="font-semibold">No Pendaftaran</p><p id="m-no"></p>
            <p class="font-semibold">Model</p><p id="m-model"></p>
            <p class="font-semibold">Tarikh Pelepasan</p><p id="m-tarikh"></p>
            <p class="font-semibold">Lokasi</p><p id="m-lokasi"></p>
            <p class="font-semibold">Bil Penumpang</p><p id="m-bil"></p>
            <p class="font-semibold">Kod Projek</p><p id="m-kod"></p>
            <p class="font-semibold">Hak Milik</p><p id="m-hak"></p>
        </div>

        <div class="mt-6">
            <p class="font-semibold mb-3">Lampiran</p>
            <div id="m-lampiran" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"></div>
            <p id="m-no-lampiran" class="text-sm text-gray-500 hidden">Tiada lampiran.</p>
        </div>

        <div class="mt-8 text-right">
            <button data-modal-close class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tutup</button>
        </div>
    </div>
</div>
@endsection
