@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-poppins text-3xl sm:text-4xl font-extrabold text-[#2B3A8C] tracking-tight">Surat Masuk</h1>
                <p class="text-gray-500 text-sm mt-1">
                    @if(auth()->user()->role === 'sekretaris')
                        Semua surat masuk dari seluruh unit
                    @elseif(in_array(auth()->user()->jabatan, ['direktur','kabag']))
                        Monitoring surat masuk
                    @else
                        Surat masuk yang kamu kirim
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if(in_array(auth()->user()->role, ['super_admin','admin','sekretaris']))
                <a href="{{ route('eoffice.surat-masuk.export') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-white text-green-600 font-bold text-sm rounded-2xl
                           shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Export</span>
                </a>
                @endif

                {{-- @if(!in_array(auth()->user()->jabatan, ['direktur', 'kabag'])) --}}
                <a href="{{ route('eoffice.surat-masuk.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-white text-[#2B3A8C] font-bold text-sm rounded-2xl
                           shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                        <span>Tambah Surat</span>
                    @else
                        <span>Kirim Surat</span>
                    @endif
                </a>
                {{-- @endif --}}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16">

        @if(auth()->user()->role === 'sekretaris' && $suratMenunggu > 0)
        <div class="flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-2xl px-5 py-3.5 mb-5">
            <div class="w-2.5 h-2.5 rounded-full bg-orange-400 animate-pulse flex-shrink-0"></div>
            <p class="text-sm font-semibold text-orange-700">
                {{ $suratMenunggu }} surat dari unit menunggu diproses
            </p>
        </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 sm:p-8">

            <div class="mb-8">
                <form method="GET" action="{{ route('eoffice.surat-masuk.index') }}">
                    <div class="flex flex-col gap-4">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor agenda / perihal / nomor surat..."
                            class="w-full bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3.5 px-6 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] transition">

                        <div class="flex flex-wrap items-center gap-3">

                            <select name="kategori" id="filterKategori"
                                onchange="filterUnitByKategori(this.value)"
                                class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3 px-5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] min-w-[170px]">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $kat => $units)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                                @endforeach
                            </select>

                            <select name="unit" id="filterUnit"
                                class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3 px-5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] min-w-[160px]
                                       {{ request('kategori') ? '' : 'opacity-50 cursor-not-allowed' }}"
                                {{ request('kategori') ? '' : 'disabled' }}>
                                <option value="">Semua Unit</option>
                                @foreach($kategoriList as $kat => $units)
                                    @foreach($units as $unitNama)
                                    <option value="{{ $unitNama }}"
                                        data-kategori="{{ $kat }}"
                                        {{ request('unit') == $unitNama ? 'selected' : '' }}
                                        class="unit-option">
                                        {{ $unitNama }}
                                    </option>
                                    @endforeach
                                @endforeach
                            </select>

                            <select name="prioritas"
                                class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3 px-5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                                <option value="">Semua Prioritas</option>
                                <option value="segera" {{ request('prioritas') == 'segera' ? 'selected' : '' }}>🔴 Segera</option>
                                <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="biasa"  {{ request('prioritas') == 'biasa'  ? 'selected' : '' }}>🟢 Biasa</option>
                            </select>

                            <select name="status"
                                class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3 px-5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                                <option value="">Semua Status</option>
                                <option value="menunggu_sekretaris" {{ request('status') == 'menunggu_sekretaris' ? 'selected' : '' }}>Menunggu Acc</option>
                                <option value="menunggu_direktur"   {{ request('status') == 'menunggu_direktur'   ? 'selected' : '' }}>Menunggu Direktur</option>
                                <option value="menunggu_kabag"      {{ request('status') == 'menunggu_kabag'      ? 'selected' : '' }}>Menunggu Kabag</option>
                                <option value="pending"             {{ request('status') == 'pending'             ? 'selected' : '' }}>Pending</option>
                                <option value="disetujui"           {{ request('status') == 'disetujui'           ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak"             {{ request('status') == 'ditolak'             ? 'selected' : '' }}>Ditolak</option>
                            </select>

                            <div class="flex gap-2 ml-auto">
                                <button type="submit"
                                    class="px-8 py-3 bg-[#2B3A8C] text-white text-sm font-bold rounded-2xl
                                           hover:bg-blue-800 transition shadow-lg shadow-blue-100">
                                    Cari
                                </button>
                                @if(request()->hasAny(['search','kategori','prioritas','status']))
                                <a href="{{ route('eoffice.surat-masuk.index') }}"
                                    class="px-5 py-3 bg-gray-100 text-gray-600 text-sm font-bold rounded-2xl hover:bg-gray-200 transition">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-50 text-xs uppercase tracking-widest">
                            <th class="text-left px-4 py-4 font-bold">No. Agenda</th>
                            <th class="text-left px-4 py-4 font-bold">Asal Surat</th>
                            <th class="text-left px-4 py-4 font-bold">Kategori Unit</th>
                            <th class="text-left px-4 py-4 font-bold">Unit Pengirim</th>
                            <th class="text-left px-4 py-4 font-bold">Perihal</th>
                            <th class="text-left px-4 py-4 font-bold">Tgl Masuk</th>
                            
                            @if(auth()->user()->hasRole(['super_admin', 'sekretaris']))
                            <th class="text-left px-4 py-4 font-bold">Prioritas</th>
                            @endif
                            <th class="text-left px-4 py-4 font-bold">Status</th>
                            <th class="text-center px-4 py-4 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($suratMasuk as $surat)

                        <tr class="hover:bg-[#F8FAFF] transition
                            {{ $surat->status === 'menunggu_sekretaris' && auth()->user()->role === 'sekretaris' ? 'bg-orange-50/50' : '' }}
                            {{ $surat->status === 'pending' ? 'bg-yellow-50/40' : '' }}">

                            <td class="px-4 py-5 font-mono font-bold text-[#2B3A8C] whitespace-nowrap">
                                {{ $surat->nomor_agenda }}
                            </td>

                            <td class="px-4 py-5">
                                <p class="text-gray-700 font-medium">{{ $surat->asal_surat }}</p>
                            </td>

                            <td class="px-4 py-5">
                                @php
                                    $kategoriColor = [
                                        'Pelayanan Medis'  => 'bg-blue-50 text-blue-700',
                                        'Penunjang Medis'  => 'bg-purple-50 text-purple-700',
                                        'Keperawatan'      => 'bg-pink-50 text-pink-700',
                                        'Umum'             => 'bg-gray-100 text-gray-600',
                                        'Keuangan'         => 'bg-green-50 text-green-700',
                                    ];
                                    $kat = $surat->pembuat->kategori_unit ?? '-';
                                    $kColor = $kategoriColor[$kat] ?? 'bg-gray-100 text-gray-500';
                                @endphp
                                <span class="text-xs px-2.5 py-1 rounded-lg font-semibold {{ $kColor }} whitespace-nowrap">
                                    {{ $kat }}
                                </span>
                            </td>

                            <td class="px-4 py-5">
                                <div>
                                    <p class="text-xs font-semibold text-gray-700">{{ $surat->pembuat->unit_kerja ?? '-' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $surat->pembuat->nama_lengkap ?? '' }}</p>
                                </div>
                            </td>

                            <td class="px-4 py-5 max-w-[220px]">
                                <p class="font-semibold text-gray-700 truncate">{{ $surat->perihal }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $surat->nomor_surat ?? '-' }}</p>
                            </td>

                            <td class="px-4 py-5 text-xs text-gray-400 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($surat->tanggal_masuk)->translatedFormat('d M Y') }}
                            </td>

                            @if(auth()->user()->hasRole(['super_admin', 'sekretaris']))
                            <td class="px-4 py-5">
                                @if($surat->prioritas === 'segera')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-600">🔴 SEGERA</span>
                                @elseif($surat->prioritas === 'sedang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-600">🟡 SEDANG</span>
                                @elseif($surat->prioritas === 'biasa')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600">🟢 BIASA</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-400">— Belum diset</span>
                                @endif
                            </td>
                            @endif

                            <td class="px-4 py-5">
                                @php
                                    $sm = [
                                        'menunggu_sekretaris' => ['text-orange-700', 'Menunggu Acc'],
                                        'menunggu_direktur'   => ['text-yellow-700', 'Menunggu Direktur'],
                                        'menunggu_kabag'      => ['text-blue-700',     'Menunggu Kabag'],
                                        'pending'             => ['text-yellow-600',  'Pending'],
                                        'disetujui'           => ['text-green-700',   'Disetujui'],
                                        'ditolak'             => ['text-red-700',       'Ditolak'],
                                    ];
                                    [$cls, $lbl] = $sm[$surat->status] ?? ['text-red-700', ucfirst($surat->status)];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[12px] font-poppins font-bold {{ $cls }}
                                    {{ $surat->status === 'menunggu_sekretaris' ? 'animate-pulse' : '' }}">
                                    {{ $lbl }}
                                </span>
                            </td>

                            <td class="px-4 py-5">
                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('eoffice.surat-masuk.show', $surat->id) }}"
                                        class="inline-flex items-center justify-center p-2.5 bg-blue-50 text-blue-600 rounded-xl
                                               hover:bg-[#2B3A8C] hover:text-white transition"
                                        title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'sekretaris' && $surat->status === 'menunggu_sekretaris')
                                    <a href="{{ route('eoffice.surat-masuk.edit', $surat->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-2.5 bg-[#2B3A8C] text-white text-xs font-bold
                                               rounded-xl hover:bg-blue-900 transition"
                                        title="Proses & Teruskan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Proses
                                    </a>
                                    @endif

                                    @if($surat->status === 'pending' && auth()->user()->jabatan === 'kabag')
                                    <a href="{{ route('eoffice.surat-masuk.edit', $surat->id) }}" 
                                        class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                                        <img src="{{ asset('images/Edit.svg') }}" class="w-4 h-4" style="min-width:20px;min-height:20px;">
                                    </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-20 text-center text-gray-400 italic"> 
                                Belum ada data surat masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suratMasuk->hasPages())
            <div class="mt-8 pt-6 border-t border-gray-50">
                {{ $suratMasuk->links() }}
            </div>
            @endif

        </div>
    </div>
</div>
<script>
const unitPerKategori = {
    'Kabid Keperawatan': [
        'Unit Poliklinik Rawat Jalan',
        'Instalasi Gawat Darurat',
        'Unit Rawat Inap Ruang Lotus',
        'Unit Rawat Inap Ruang Rosalina',
        'Unit Rawat Inap Ruang Alamanda',
        'Unit Rawat Inap Ruang Teratai',
        'Unit Rawat Inap Ruang Anturium',
        'Unit Rawat Inap Ruang Tulip',
        'Unit Kamar Operasi',
        'Unit ICU',
        'Unit Hemodialisis',
        'Unit Kamar Bersalin',
        'Unit Perinatologi',
    ],
    'Kabid Pelayanan Medis': [
        'Unit Poliklinik Rawat Jalan',
        'Instalasi Gawat Darurat',
        'Unit Rawat Inap Ruang Lotus',
        'Unit Rawat Inap Ruang Rosalina',
        'Unit Rawat Inap Ruang Alamanda',
        'Unit Rawat Inap Ruang Teratai',
        'Unit Rawat Inap Ruang Anturium', 
        'Unit Rawat Inap Ruang Tulip',
        'Unit Kamar Operasi',
        'Unit ICU',
        'Unit Hemodialisis',
        'Unit Kamar Bersalin',
        'Unit Perinatologi',
    ],
    'Kabid Penunjang Medis': [
        'Unit Radiologi',
        'Unit Laboratorium',
        'Unit Gizi',
        'Unit Farmasi',
        'Unit Rekam Medik',
    ],
    'Kabag Umum & Keuangan': [
        'Unit Umum Rumah Tangga',
        'Unit Informasi & TI',
        'Unit Keuangan',
        'Unit Pajak',
        'Unit Akuntansi',
        'Unit Kepegawaian & Diklat',
    ],
};

const filterKategori = document.getElementById('filterKategori');
const filterUnit     = document.getElementById('filterUnit');

function filterUnitByKategori(kategori) {
    filterUnit.innerHTML = '<option value="">Semua Unit</option>';

    if (!kategori) {
        filterUnit.disabled = true;
        filterUnit.classList.add('opacity-50', 'cursor-not-allowed');
        return;
    }

    filterUnit.disabled = false;
    filterUnit.classList.remove('opacity-50', 'cursor-not-allowed');

    const units = unitPerKategori[kategori] || [];
    units.forEach(unit => {
        const opt = document.createElement('option');
        opt.value       = unit;
        opt.textContent = unit;
        if ('{{ request("unit") }}' === unit) opt.selected = true;
        filterUnit.appendChild(opt);
    });
}

document.addEventListener('DOMContentLoaded', () => { 
    const initKategori = filterKategori.value;
    if (initKategori) {
        filterUnitByKategori(initKategori);
    }
});
</script>

@endsection