@extends('user_site.layout.layout')

@section('title', 'Status Permohonan')

@section('content')
<div class="max-w-5xl mx-auto mt-10 mb-20">
    <h1 class="text-3xl font-bold text-center mb-6 text-[#1e3a8a]">Status Permohonan</h1>

    <table class="w-full border-collapse shadow-md rounded-xl overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="border border-gray-300 px-4 py-3 text-left">Perkara</th>
                <th class="border border-gray-300 px-4 py-3 w-40 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonan ?? [] as $item)
                <tr class="bg-white border-b border-gray-200">
                    {{-- Left column: Perkara --}}
                    <td class="border border-gray-300 px-4 py-3 align-top">
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Column 1 --}}
                            <div class="space-y-1 text-gray-700 font-semibold">
                                <p>ID User:</p>
                                <p>No. Pendaftaran:</p>
                                <p>Lokasi:</p>
                            </div>
                            <div class="space-y-1 text-gray-800">
                                <p>{{ $item->id_user }}</p>
                                <p>{{ $item->no_pendaftaran }}</p>
                                <p>{{ $item->lokasi }}</p>
                            </div>

                            {{-- Column 2 --}}
                            <div class="space-y-1 text-gray-700 font-semibold">
                                <p>Bil. Penumpang:</p>
                                <p>Kod Projek:</p>
                                <p>Hak Milik:</p>
                            </div>
                            <div class="space-y-1 text-gray-800">
                                <p>{{ $item->bil_penumpang }}</p>
                                <p>{{ $item->kod_projek }}</p>
                                <p>{{ $item->hak_milik }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Right column: Status full height + centered text --}}
                    <td class="border border-gray-300 p-0 align-top">
                        <div class="h-full w-full flex items-center justify-center
                            @if($item->status_pengesahan === 'menunggu') bg-yellow-400 text-white
                            @elseif($item->status_pengesahan === 'lulus') bg-green-500 text-white
                            @elseif($item->status_pengesahan === 'tolak') bg-red-500 text-white
                            @else bg-gray-400 text-white @endif
                            font-semibold text-center py-4">
                            {{ ucfirst($item->status_pengesahan) }}
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center text-gray-500 py-6">Tiada rekod permohonan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
