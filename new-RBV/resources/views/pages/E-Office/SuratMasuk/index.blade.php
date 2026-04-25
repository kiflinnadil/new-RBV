@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="font-poppins text-2xl sm:text-3xl font-extrabold text-[#2B3A8C]">Surat Masuk</h1>
                <p class="text-gray-400 text-xs mt-0.5">
                    @if(auth()->user()->role === 'sekretaris')
                        Semua surat masuk dari seluruh unit
                    @else
                        Surat masuk yang kamu kirim
                    @endif
                </p>
            </div>
            <a href="{{ route('eoffice.surat-masuk.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl
                       hover:shadow-lg hover:shadow-blue-200 transition self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Surat
            </a>
        </div>

        @if(auth()->user()->role === 'sekretaris')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <form method="GET" action="{{ route('eoffice.surat-masuk.index') }}"
                  class="flex flex-wrap items-end gap-3">

                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs text-gray-400 mb-1 ml-1">Filter Unit</label>
                    <select name="unit"
                        class="w-full bg-[#F3F4F6] rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                        <option value="">Semua Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs text-gray-400 mb-1 ml-1">Status</label>
                    <select name="status"
                        class="w-full bg-[#F3F4F6] rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                        <option value="">Semua Status</option>
                        <option value="menunggu_sekretaris" {{ request('status') == 'menunggu_sekretaris' ? 'selected' : '' }}>Menunggu Acc</option>
                        <option value="menunggu_direktur"   {{ request('status') == 'menunggu_direktur'   ? 'selected' : '' }}>Menunggu Direktur</option>
                        <option value="menunggu_kabag"      {{ request('status') == 'menunggu_kabag'      ? 'selected' : '' }}>Menunggu Kabag</option>
                        <option value="disetujui"           {{ request('status') == 'disetujui'           ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak"             {{ request('status') == 'ditolak'             ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs text-gray-400 mb-1 ml-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nomor surat / perihal..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl hover:bg-blue-900 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['unit','status','search']))
                    <a href="{{ route('eoffice.surat-masuk.index') }}"
                        class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">
                        Reset
                    </a>
                    @endif
                </div>

            </form>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            @if(auth()->user()->role === 'sekretaris' && $suratMenunggu > 0)
            <div class="flex items-center gap-2 px-5 py-3 bg-yellow-50 border-b border-yellow-100">
                <div class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></div>
                <p class="text-xs font-semibold text-yellow-700">
                    {{ $suratMenunggu }} surat menunggu acc dari kamu
                </p>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#F8FAFF] border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">No. Agenda</th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Perihal</th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Asal Surat</th>
                            @if(auth()->user()->role === 'sekretaris')
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Unit Pengirim</th>
                            @endif
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Tgl Masuk</th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Prioritas</th>
                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-500">Status</th>
                            <th class="text-center px-5 py-3 text-xs font-bold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($suratMasuk as $surat)
                        <tr class="hover:bg-[#F8FAFF] transition">

                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-bold text-[#2B3A8C]">{{ $surat->nomor_agenda }}</span>
                            </td>

                            <td class="px-5 py-4 max-w-[200px]">
                                <p class="font-semibold text-gray-700 truncate">{{ $surat->perihal }}</p>
                                <p class="text-[10px] text-gray-400">{{ $surat->nomor_surat ?? '-' }}</p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-gray-600 text-xs">{{ $surat->asal_surat }}</p>
                            </td>

                            @if(auth()->user()->role === 'sekretaris')
                            <td class="px-5 py-4">
                                <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded-lg font-semibold">
                                    {{ $surat->pembuat->unit_kerja ?? '-' }}
                                </span>
                            </td>
                            @endif

                            <td class="px-5 py-4">
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($surat->tanggal_masuk)->translatedFormat('d M Y') }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                @if($surat->prioritas === 'segera')
                                    <span class="text-[10px] px-2 py-1 rounded-lg font-semibold bg-red-100 text-red-700">🔴 Segera</span>
                                @elseif($surat->prioritas === 'sedang')
                                    <span class="text-[10px] px-2 py-1 rounded-lg font-semibold bg-yellow-100 text-yellow-700">🟡 Sedang</span>
                                @elseif($surat->prioritas === 'biasa')
                                    <span class="text-[10px] px-2 py-1 rounded-lg font-semibold bg-green-100 text-green-700">🟢 Biasa</span>
                                @else
                                    <span class="text-[10px] px-2 py-1 rounded-lg font-semibold bg-gray-100 text-gray-500">— Belum diset</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @php
                                    $statusConfig = [
                                        'menunggu_sekretaris' => ['bg-orange-100', 'text-orange-700', 'Menunggu Acc'],
                                        'menunggu_direktur'   => ['bg-yellow-100', 'text-yellow-700', 'Menunggu Direktur'],
                                        'menunggu_kabag'      => ['bg-blue-100',   'text-blue-700',   'Menunggu Kabag'],
                                        'disetujui'           => ['bg-green-100',  'text-green-700',  'Disetujui'],
                                        'ditolak'             => ['bg-red-100',    'text-red-700',    'Ditolak'],
                                    ];
                                    [$bg, $tc, $label] = $statusConfig[$surat->status] ?? ['bg-gray-100','text-gray-500','—'];
                                @endphp
                                <span class="text-[10px] px-2 py-1 rounded-lg font-semibold {{ $bg }} {{ $tc }}
                                    {{ $surat->status === 'menunggu_sekretaris' ? 'animate-pulse' : '' }}">
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('eoffice.surat-masuk.show', $surat->id) }}"
                                        class="flex items-center justify-center w-8 h-8 bg-[#EEF2FF] text-[#2B3A8C]
                                               rounded-lg hover:bg-[#2B3A8C] hover:text-white transition"
                                        title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'sekretaris' && $surat->status === 'menunggu_sekretaris')
                                    <form action="{{ route('eoffice.surat-masuk.setujui', $surat->id) }}" method="POST"
                                          onsubmit="return confirm('Acc surat ini dan teruskan ke Direktur?')">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-1.5 px-3 h-8 bg-green-500 text-white text-xs font-bold
                                                   rounded-lg hover:bg-green-600 transition"
                                            title="Acc & Teruskan ke Direktur">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Acc
                                        </button>
                                    </form>

                                    <button onclick="openTolakModal({{ $surat->id }})"
                                        class="flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 
                                               rounded-lg hover:bg-red-600 hover:text-white transition"
                                        title="Tolak Surat">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center text-gray-400 text-sm italic">
                                Belum ada surat masuk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suratMasuk->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $suratMasuk->links() }}
            </div>
            @endif

        </div>
    </div>
</div>

<div id="modalTolak" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[30px] p-8 max-w-sm w-full shadow-2xl">
        <h2 class="font-poppins text-lg font-extrabold text-[#2B3A8C] mb-1">Tolak Surat</h2>
        <p class="text-xs text-gray-400 mb-4">Berikan alasan penolakan agar unit dapat memperbaiki surat.</p>

        <form id="formTolak" action="" method="POST">
            @csrf
            <textarea name="catatan_tolak" rows="3" required
                placeholder="Alasan penolakan..."
                class="w-full bg-[#F3F4F6] rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none mb-4"></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeTolakModal()"
                    class="flex-1 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition">
                    Tolak Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openTolakModal(id) {
    document.getElementById('formTolak').action = '/eoffice/surat-masuk/' + id + '/tolak';
    document.getElementById('modalTolak').classList.remove('hidden');
}
function closeTolakModal() {
    document.getElementById('modalTolak').classList.add('hidden');
}
</script>

@endsection