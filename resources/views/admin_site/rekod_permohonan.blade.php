@extends('admin_site.layout.layout')

@section('title', 'Rekod Permohonan')

@section('content')
<h1 class="text-3xl font-bold text-center mt-20 mb-8 text-blue-900">
    Rekod Permohonan
</h1>

<div class="flex justify-between items-center mb-4 w-full max-w-6xl mx-auto">
    <select id="filterPermohonan" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Rekod</option>
        <option value="selesai">Lulus</option>
        <option value="tidak_lulus">Tidak Lulus</option>
    </select>

    <p class="text-sm text-gray-500">
        Rekod ini memaparkan permohonan yang telah selesai atau ditolak.
    </p>
</div>

<div class="flex flex-col items-center max-w-6xl mx-auto">
@forelse ($senarai as $item)
<div
    data-modal-open="modalPermohonan"
    data-status="{{ $item->status_pengesahan === 'Selesai Perjalanan' ? 'selesai' : 'tidak_lulus' }}"
    data-user="{{ $item->user->nama ?? '-' }}"
    data-idpekerja="{{ $item->user->id_pekerja ?? '-' }}"
    data-no="{{ $item->no_pendaftaran }}"
    data-model="{{ $item->kenderaan->model ?? '-' }}"
    data-tarikh="{{ $item->tarikh_pelepasan }}"
    data-lokasi="{{ $item->lokasi }}"
    data-bil="{{ $item->bil_penumpang }}"
    data-kod="{{ $item->kod_projek }}"
    data-hak="{{ $item->hak_milik }}"
    data-lampiran='@json($item->lampiran ?? [])'
    data-speedometer-sebelum="{{ $item->speedometer_sebelum }}"
    data-speedometer-selepas="{{ $item->speedometer_selepas }}"
    data-ulasan="{{ $item->ulasan }}"
    class="permohonan-card bg-white shadow-md rounded-xl p-5 mb-4 border hover:shadow-lg transition cursor-pointer w-full"
>
    <div class="flex justify-between mb-3">
        <div class="text-sm text-gray-600 space-y-1">
            <p>Pemohon: <span class="font-medium">{{ $item->user->nama ?? '-' }}</span></p>
            <p>No Pendaftaran: <span class="font-medium">{{ $item->no_pendaftaran }}</span></p>
            <p>Model: <span class="font-medium">{{ $item->kenderaan->model ?? '-' }}</span></p>
            <p>Lokasi: <span class="font-medium">{{ $item->lokasi ?? '-' }}</span></p>
        </div>

        <div class="text-right text-sm text-gray-500">
            <p>Tarikh Mohon</p>
            <p class="font-medium">{{ $item->tarikh_mohon }}</p>
        </div>
    </div>
</div>
@empty
<p class="text-gray-500 mt-10">Tiada rekod permohonan dijumpai.</p>
@endforelse
</div>

{{-- ================= MODAL ================= --}}
<div id="modalPermohonan" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
    <div data-modal-card class="bg-white w-full max-w-3xl rounded-xl shadow-lg transform scale-95 opacity-0 transition-all duration-200 flex flex-col max-h-[90vh]">

        {{-- HEADER --}}
        <div class="p-6 border-b border-gray-200 flex justify-center">
            <h2 class="text-xl font-bold text-center">MAKLUMAT PERMOHONAN KENDERAAN</h2>
        </div>

        {{-- BODY (scrollable) --}}
        <div class="p-6 overflow-y-auto flex-1 space-y-6">

            {{-- Basic Info --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <p class="font-semibold">Nama Pemohon</p><p id="m-user"></p>
                <p class="font-semibold">ID Pekerja</p><p id="m-idpekerja"></p>
                <p class="font-semibold">No Pendaftaran</p><p id="m-no"></p>
                <p class="font-semibold">Model</p><p id="m-model"></p>
                <p class="font-semibold">Tarikh Pelepasan</p><p id="m-tarikh"></p>
                <p class="font-semibold">Lokasi</p><p id="m-lokasi"></p>
                <p class="font-semibold">Bil Penumpang</p><p id="m-bil"></p>
                <p class="font-semibold">Kod Projek</p><p id="m-kod"></p>
                <p class="font-semibold">Hak Milik</p><p id="m-hak"></p>
            </div>

            {{-- Lampiran --}}
            <div>
                <p class="font-semibold mb-3">Lampiran</p>
                <div id="m-lampiran" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"></div>
                <p id="m-no-lampiran" class="text-sm text-gray-500 hidden">Tiada lampiran.</p>
            </div>

            {{-- SPEEDOMETER --}}
            <div id="m-speedometer-section" class="hidden">
                <p class="font-semibold mb-3">Rekod Speedometer</p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col items-center">
                        <p class="text-sm font-medium mb-1">Sebelum</p>
                        <img id="m-speedometer-sebelum" class="h-32 w-full object-contain rounded border speedometer-preview">
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="text-sm font-medium mb-1">Selepas</p>
                        <img id="m-speedometer-selepas" class="h-32 w-full object-contain rounded border speedometer-preview">
                    </div>
                </div>

                <div class="mt-3">
                    <p class="font-semibold">Ulasan</p>
                    <p id="m-ulasan" class="text-sm text-gray-700"></p>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="p-4 border-t border-gray-200 flex justify-end">
            <button data-modal-close class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tutup</button>
        </div>

    </div>
</div>
@endsection
