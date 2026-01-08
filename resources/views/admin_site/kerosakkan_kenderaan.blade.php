@extends('admin_site.layout.layout')

@section('title', 'Kerosakan Kenderaan')

@section('content')
<h1 class="text-3xl font-bold text-center mt-20 mb-8 text-blue-900">
    Kerosakan Kenderaan
</h1>

@if($action === 'add')
    {{-- =================== FORM TAMBAH LAPORAN =================== --}}
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 border border-gray-200 mb-10">
        <h2 class="text-xl font-bold text-center mb-6 text-blue-800">Tambah Laporan Kerosakan</h2>

        <form action="{{ route('admin_site.kerosakkan_kenderaan.store') }}" method="POST">
            @csrf
            <div class="grid gap-4">
                {{-- No Pendaftaran --}}
                <div>
                    <label class="font-semibold mb-1 block">No Pendaftaran</label>
                    <select name="no_pendaftaran" id="no_pendaftaran"
                        class="w-full border border-gray-300 rounded-lg p-2"
                        onchange="document.getElementById('model').value = this.selectedOptions[0].dataset.model;">
                        <option value="">-- Pilih Kenderaan --</option>
                        @foreach($kenderaan as $k)
                            <option value="{{ $k->no_pendaftaran }}" data-model="{{ $k->model }}">
                                {{ $k->no_pendaftaran }} - {{ $k->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Kerosakan --}}
                <div>
                    <label class="font-semibold mb-1 block">Jenis Kerosakan</label>
                    <input type="text" name="jenis_kerosakan" class="w-full border border-gray-300 rounded-lg p-2" required>
                </div>

                {{-- Ulasan --}}
                <div>
                    <label class="font-semibold mb-1 block">Ulasan</label>
                    <textarea name="ulasan" rows="4" class="w-full border border-gray-300 rounded-lg p-2"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin_site.kerosakkan_kenderaan') }}"
                   class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">Batal</a>

                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@else
    {{-- BUTTON TAMBAH LAPORAN --}}
    <div class="text-right max-w-5xl mx-auto mb-6">
        <a href="{{ route('admin_site.kerosakkan_kenderaan', ['action' => 'add']) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Tambah Laporan
        </a>
    </div>

    {{-- ================== SENARAI ================== --}}
    <div class="max-w-5xl mx-auto flex flex-col gap-4">
        @foreach($senarai as $item)
        <div
            data-modal-open="modalPermohonan"
            data-id="{{ $item->id_laporan }}"
            data-no="{{ $item->no_pendaftaran }}"
            data-model="{{ $item->kenderaan->model ?? '-' }}"
            data-tarikh="{{ \Carbon\Carbon::parse($item->tarikh_laporan)->format('d/m/Y') }}"
            data-jenis="{{ $item->jenis_kerosakan }}"
            data-ulasan="{{ $item->ulasan ?? '-' }}"
            class="bg-white p-5 rounded-xl shadow-md border hover:shadow-lg cursor-pointer transition">

            <div class="flex justify-between">
                <div>
                    <p class="font-semibold text-lg text-blue-900">
                        {{ $item->kenderaan->model ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        No Pendaftaran:
                        <span class="font-medium">{{ $item->no_pendaftaran }}</span>
                    </p>
                </div>
                <div class="text-right text-sm text-gray-500">
                    <p>Tarikh Laporan:</p>
                    <p class="font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($item->tarikh_laporan)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- ================= MODAL DETAIL ================= --}}
<div id="modalPermohonan" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg p-6 transform scale-95 opacity-0 transition-all duration-200">
        <h2 class="text-xl font-bold text-center mb-6 text-blue-800">
            Maklumat Laporan Kerosakan
        </h2>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <p class="font-semibold">No Pendaftaran:</p> <p id="m-no">-</p>
            <p class="font-semibold">Model:</p> <p id="m-model">-</p>
            <p class="font-semibold">Jenis Kerosakan:</p> <p id="m-jenis">-</p>
            <p class="font-semibold">Ulasan:</p> <p id="m-ulasan">-</p>
            <p class="font-semibold">Tarikh Laporan:</p> <p id="m-tarikh">-</p>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <form id="formSelesai" method="POST">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg">
                    Selesai
                </button>
            </form>
            <button data-modal-close class="px-4 py-2 bg-gray-300 rounded-lg">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection
