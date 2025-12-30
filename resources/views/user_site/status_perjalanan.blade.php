@extends('user_site.layout.layout')

@section('title', 'Status Perjalanan')

@section('content')
<h1 class="text-3xl font-bold text-center mt-20 mb-10">
    Status Perjalanan
</h1>

<div class="max-w-5xl mx-auto space-y-6">
@forelse($senarai as $item)
<form method="POST"
      action="{{ route('user_site.status_perjalanan.simpan') }}"
      class="border rounded-lg p-6 bg-white shadow-sm"
      enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id_permohonan"
           value="{{ $item->id_permohonan }}">

    <h2 class="font-semibold mb-4">
        {{ $item->no_pendaftaran }}
    </h2>

    {{-- TARIKH ROADTAX --}}
    <div class="mb-3">
        <label class="text-sm font-medium">
            Tarikh Road Tax Kenderaan
        </label>
        <input type="text"
               value="{{ $item->kenderaan->tarikh_tamat_roadtax ?? '-' }}"
               readonly
               class="w-full mt-1 bg-gray-100 border rounded px-3 py-2">
    </div>

    {{-- SPEEDOMETER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">

        {{-- SEBELUM --}}
        <div>
            <label class="text-sm font-medium">
                Speedometer Sebelum
            </label>

            {{-- 🔥 CHANGED: show preview if exists --}}
            @if($item->speedometer_sebelum)
                <img
                    src="{{ asset('storage/'.$item->speedometer_sebelum) }}"
                    class="speedometer-preview cursor-pointer mt-2 mb-1"
                    data-modal-img="{{ asset('storage/'.$item->speedometer_sebelum) }}"
                    style="max-height:150px"
                >
                <p class="text-xs text-green-600">✔ Telah dimuat naik</p>
            @endif

            <input type="file"
                   name="speedometer_sebelum"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="w-full mt-1 border rounded px-3 py-2">
        </div>

        {{-- SELEPAS --}}
        <div>
            <label class="text-sm font-medium">
                Speedometer Selepas
            </label>

            {{-- 🔥 CHANGED --}}
            @if($item->speedometer_selepas)
                <img
                    src="{{ asset('storage/'.$item->speedometer_selepas) }}"
                    class="speedometer-preview cursor-pointer mt-2 mb-1"
                    data-modal-img="{{ asset('storage/'.$item->speedometer_selepas) }}"
                    style="max-height:150px"
                >
                <p class="text-xs text-green-600">✔ Telah dimuat naik</p>
            @endif

            <input type="file"
                   name="speedometer_selepas"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="w-full mt-1 border rounded px-3 py-2">
        </div>
    </div>

    {{-- ULASAN --}}
    <div class="mb-4">
        <label class="text-sm font-medium">
            Ulasan (Jika Ada)
        </label>
        <textarea name="ulasan"
                  class="w-full mt-1 border rounded px-3 py-2"
                  rows="3">{{ $item->ulasan }}</textarea>
    </div>

    <button type="submit"
            class="px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
        Simpan
    </button>
</form>
@empty
<p class="text-center text-gray-500">
    Tiada perjalanan direkodkan.
</p>
@endforelse
</div>
@endsection
