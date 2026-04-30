@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('eoffice.surat-masuk.index') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">Detail Surat Masuk</h1>
                    <p class="font-mono text-sm text-gray-400">{{ $surat->nomor_agenda }}</p>
                </div>
            </div>
            <a href="{{ route('eoffice.surat-masuk.export-pdf', $surat->id) }}"
                class="flex items-center gap-2 px-6 py-3 bg-white text-red-600 font-bold text-sm rounded-2xl
                       shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 self-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                PDF
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4 pb-2 border-b border-gray-100">Informasi Surat</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">No. Agenda</p>
                        <p class="font-mono font-bold text-[#2B3A8C]">{{ $surat->nomor_agenda }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">No. Surat</p>
                        <p class="font-semibold text-gray-700">{{ $surat->nomor_surat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Tgl Surat</p>
                        <p class="font-semibold text-gray-700">
                            {{ $surat->tanggal_surat ? $surat->tanggal_surat->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Tgl Diterima</p>
                        <p class="font-semibold text-gray-700">{{ $surat->tanggal_masuk->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Asal Surat</p>
                        <p class="font-semibold text-gray-700">{{ $surat->asal_surat }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Jenis</p>
                        <span class="text-xs px-2 py-1 rounded-lg font-semibold
                            {{ $surat->jenis == 'internal' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' }}">
                            {{ ucfirst($surat->jenis) }}
                        </span>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 mb-0.5">Perihal</p>
                        <p class="font-semibold text-gray-700">{{ $surat->perihal }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Prioritas</p>
                        @if($surat->prioritas == 'segera')
                            <span class="text-xs px-2 py-1 rounded-lg font-semibold bg-red-100 text-red-700">🔴 Segera</span>
                        @elseif($surat->prioritas == 'sedang')
                            <span class="text-xs px-2 py-1 rounded-lg font-semibold bg-yellow-100 text-yellow-700">🟡 Sedang</span>
                        @elseif($surat->prioritas == 'biasa')
                            <span class="text-xs px-2 py-1 rounded-lg font-semibold bg-green-100 text-green-700">🟢 Biasa</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded-lg font-semibold bg-gray-100 text-gray-500">Belum diset</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Pengirim</p>
                        <p class="font-semibold text-gray-700">
                            {{ $surat->pembuat->nama_lengkap ?? '-' }}
                            <span class="text-gray-400 font-normal text-xs">({{ $surat->pembuat->unit_kerja ?? '' }})</span>
                        </p>
                    </div>
                </div>

                @if($surat->catatan)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 mb-1">Catatan Sekretaris</p>
                    <p class="text-sm text-gray-700 bg-[#F8FAFF] rounded-xl p-3">{{ $surat->catatan }}</p>
                </div>
                @endif

                @if($surat->catatan_tolak)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-red-400 mb-1">Alasan Penolakan</p>
                    <p class="text-sm text-red-700 bg-red-50 rounded-xl p-3">{{ $surat->catatan_tolak }}</p>
                </div>
                @endif

                @if($surat->catatan_pending ?? null)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-yellow-600 mb-1">Catatan Pending (Kabag)</p>
                    <p class="text-sm text-yellow-700 bg-yellow-50 rounded-xl p-3">{{ $surat->catatan_pending }}</p>
                </div>
                @endif
            </div>

            @if($surat->tags->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Penerima / Disposisi</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($surat->tags as $tag)
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-xs font-semibold">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $tag->user->nama_lengkap ?? '-' }}
                        <span class="text-blue-400 text-[10px]">({{ ucfirst($tag->user->role ?? '') }})</span>
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($surat->file_scan)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">File Scan Surat</h2>
                <a href="{{ asset('storage/'.$surat->file_scan) }}" target="_blank"
                    class="flex items-center gap-3 p-3 bg-[#F8FAFF] rounded-xl hover:bg-blue-50 transition">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-[#2B3A8C] font-semibold">Lihat / Download File Scan</span>
                </a>
            </div>
            @endif

            @if($bisaApprove)
            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-5 sm:p-6">

                <div class="flex items-center gap-2 mb-5">
                    <div class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></div>
                    <h2 class="font-poppins font-bold text-yellow-700 text-sm">
                        Tindakan Persetujuan — {{ ucfirst($jabatanApproval) }}
                    </h2>
                </div>

                <div class="mb-5">
                    <label class="block text-xs text-gray-500 mb-1.5 ml-1">Catatan</label>
                    <textarea id="catatanApproval" rows="3"
                        placeholder="Tulis catatan persetujuan atau alasan penolakan..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none"></textarea>
                </div>

                @if($jabatanApproval === 'direktur')
                <div class="mb-5">
                    <label class="block text-xs text-gray-500 mb-2 ml-1 font-bold">
                        Tag Unit Terkait <span class="font-normal text-gray-400">(Opsional — bisa pilih lebih dari satu)</span>
                    </label>

                    <div class="flex rounded-xl overflow-hidden border border-gray-200 mb-3"
                         x-data="{ openKat: false, aktifKat: '' }">

                        {{-- <div class="relative">
                            <button type="button"
                                @click="openKat = !openKat"
                                class="inline-flex items-center gap-1.5 h-full px-3 py-2.5 bg-[#F3F4F6] text-gray-600
                                       text-xs font-semibold border-r border-gray-200 hover:bg-gray-200 transition whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <span x-text="aktifKat || 'Semua Kategori'"></span>
                                <svg class="w-3 h-3 transition-transform" :class="openKat ? 'rotate-180' : ''"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="openKat" @click.outside="openKat = false"
                                 x-transition
                                 class="absolute left-0 top-full mt-1 z-30 bg-white border border-gray-200
                                        rounded-xl shadow-lg w-52 py-1">
                                <button type="button"
                                    @click="aktifKat = ''; openKat = false; filterKategoriUnit('')"
                                    class="w-full text-left px-4 py-2 text-xs hover:bg-[#F3F4F6] text-gray-700 font-semibold">
                                    Semua Kategori
                                </button>
                                @php
                                    $kategoriUnitList = [
                                        'Kabid Keperawatan',
                                        'Kabid Pelayanan Medis',
                                        'Kabid Penunjang Medis',
                                        'Kabag Umum & Keuangan',
                                    ];
                                @endphp
                                @foreach($kategoriUnitList as $kul)
                                <button type="button"
                                    @click="aktifKat = '{{ $kul }}'; openKat = false; filterKategoriUnit('{{ $kul }}')"
                                    class="w-full text-left px-4 py-2 text-xs hover:bg-[#F3F4F6] text-gray-600">
                                    {{ $kul }}
                                </button>
                                @endforeach
                            </div>
                        </div> --}}

                        <input type="text" id="searchUnit"
                            oninput="searchUnitHandler(this.value)"
                            placeholder="Cari nama atau unit..."
                            class="flex-1 px-4 py-2.5 text-sm bg-[#F3F4F6] focus:outline-none focus:ring-2
                                   focus:ring-[#2B3A8C] text-gray-700 placeholder:text-gray-400">

                        <div class="px-3 py-2.5 bg-[#2B3A8C] flex items-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                    </div>

                    <div id="selectedTags" class="flex flex-wrap gap-2 mb-3 min-h-[28px]"></div>

                    <div id="unitListContainer"
                        class="max-h-48 overflow-y-auto bg-[#F8FAFF] rounded-xl border border-blue-100 p-2 space-y-1">
                        @foreach($unitsTerkait as $u)
                        <label data-kategori="{{ $u->kategori_unit }}" data-nama="{{ strtolower($u->nama_lengkap) }} {{ strtolower($u->unit_kerja) }}"
                            class="unit-item flex items-center gap-2.5 p-2 rounded-lg hover:bg-blue-100 cursor-pointer transition">
                            <input type="checkbox" name="tag_units_hidden[]" value="{{ $u->id_user }}"
                                onchange="updateSelectedTags()"
                                class="unit-checkbox w-4 h-4 rounded border-gray-300 text-[#2B3A8C] focus:ring-[#2B3A8C]">
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-700">{{ $u->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-400">{{ $u->unit_kerja }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1.5 ml-1">*Unit yang dipilih akan mendapat notifikasi</p>
                </div>
                @endif

                @if($jabatanApproval === 'direktur')
                <div class="grid grid-cols-2 gap-3">

                    <form action="{{ route('eoffice.surat-masuk.tolak', $surat->id) }}" method="POST"
                          onsubmit="return transferCatatan(this,'catatan_tolak') && confirm('Tolak surat ini?')">
                        @csrf
                        <input type="hidden" name="catatan_tolak">
                        <button type="submit"
                            class="w-full py-3 bg-red-600 text-white text-sm font-bold rounded-xl
                                   hover:bg-red-700 transition flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak
                        </button>
                    </form>

                    <form action="{{ route('eoffice.surat-masuk.setujui', $surat->id) }}" method="POST"
                          onsubmit="return transferCatatanDanUnit(this)">
                        @csrf
                        <input type="hidden" name="catatan">
                        <div id="tagUnitsContainer"></div>
                        <button type="submit"
                            class="w-full py-3 bg-green-600 text-white text-sm font-bold rounded-xl
                                   hover:bg-green-700 transition flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setuju
                        </button>
                    </form>

                </div>
                @endif

                @if($jabatanApproval === 'kabag')
                <div class="flex items-center gap-3">

                    <form action="{{ route('eoffice.surat-masuk.tolak', $surat->id) }}" method="POST"
                          onsubmit="return transferCatatan(this,'catatan_tolak') && confirm('Tolak surat ini?')">
                        @csrf
                        <input type="hidden" name="catatan_tolak">
                        <button type="submit"
                            class="p-1.5 bg-red-600 text-white rounded-lg shadow hover:scale-110 transition"
                            title="Tolak Surat">
                            <img src="{{ asset('images/Tolak.svg') }}" class="w-4 h-4"
                                 onerror="this.outerHTML='<svg xmlns='http://www.w3.org/2000/svg' class='w-4 h-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/></svg>'">
                        </button>
                    </form>

                    <form action="{{ route('eoffice.surat-masuk.pending', $surat->id) }}" method="POST"
                          onsubmit="return transferCatatan(this,'catatan_pending')">
                        @csrf
                        <input type="hidden" name="catatan_pending">
                        <button type="submit"
                            class="p-1.5 bg-yellow-500 text-white rounded-lg shadow hover:scale-110 transition"
                            title="Pending">
                            <img src="{{ asset('images/Pending.svg') }}" class="w-4 h-4"
                                 onerror="this.outerHTML='<svg xmlns='http://www.w3.org/2000/svg' class='w-4 h-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'/></svg>'">
                        </button>
                    </form>

                    <form action="{{ route('eoffice.surat-masuk.setujui', $surat->id) }}" method="POST"
                          onsubmit="return transferCatatan(this,'catatan')">
                        @csrf
                        <input type="hidden" name="catatan">
                        <button type="submit"
                            class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition"
                            title="Setujui Surat">
                            <img src="{{ asset('images/Approve.svg') }}" class="w-4 h-4"
                                 onerror="this.outerHTML='<svg xmlns='http://www.w3.org/2000/svg' class='w-4 h-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M5 13l4 4L19 7'/></svg>'">
                        </button>
                    </form>

                </div>
                @endif

            </div>
            @endif

        </div>

        <div class="space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Status Surat</h2>
                @php
                    $statusConfig = [
                        'menunggu_sekretaris' => ['bg-orange-100','text-orange-700','⏳ Menunggu Sekretaris'],
                        'menunggu_direktur'   => ['bg-yellow-100','text-yellow-700','⏳ Menunggu Direktur'],
                        'menunggu_kabag'      => ['bg-blue-100',  'text-blue-700',  '⏳ Menunggu Kabag'],
                        'pending'             => ['bg-yellow-50', 'text-yellow-600','🕐 Pending'],
                        'disetujui'           => ['bg-green-100', 'text-green-700', '✅ Disetujui'],
                        'ditolak'             => ['bg-red-100',   'text-red-700',   '❌ Ditolak'],
                    ];
                    [$bg, $tc, $label] = $statusConfig[$surat->status] ?? ['bg-gray-100','text-gray-600','—'];
                @endphp
                <div class="flex items-center gap-2 p-3 {{ $bg }} rounded-xl">
                    <div class="w-2.5 h-2.5 rounded-full flex-shrink-0
                        {{ in_array($surat->status,['menunggu_sekretaris','menunggu_direktur','menunggu_kabag']) ? 'animate-pulse' : '' }}
                        {{ $tc === 'text-green-700' ? 'bg-green-500' : ($tc === 'text-red-700' ? 'bg-red-500' : 'bg-yellow-400') }}">
                    </div>
                    <span class="text-sm font-semibold {{ $tc }}">{{ $label }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4">Alur Persetujuan</h2>
                @php
                    $steps = [
                        ['label' => 'Dikirim Unit',       'done' => true],
                        ['label' => 'Acc Sekretaris',     'done' => !in_array($surat->status, ['menunggu_sekretaris'])],
                        ['label' => 'Menunggu Direktur',  'done' => in_array($surat->status, ['menunggu_kabag','pending','disetujui','ditolak'])],
                        ['label' => 'Disetujui Direktur', 'done' => in_array($surat->status, ['menunggu_kabag','pending','disetujui'])],
                        ['label' => 'Menunggu Kabag',     'done' => in_array($surat->status, ['disetujui','ditolak'])],
                        ['label' => 'Selesai',            'done' => $surat->status === 'disetujui'],
                    ];
                @endphp
                <div class="space-y-0">
                    @foreach($steps as $step)
                    <div class="flex gap-3 pb-3 relative">
                        @if(!$loop->last)
                        <div class="absolute left-3.5 top-7 bottom-0 w-0.5 {{ $step['done'] ? 'bg-[#2B3A8C]' : 'bg-gray-100' }}"></div>
                        @endif
                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center z-10
                            {{ $step['done'] ? 'bg-[#2B3A8C]' : 'bg-gray-100' }}">
                            @if($step['done'])
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            @else
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            @endif
                        </div>
                        <div class="pt-1">
                            <p class="text-xs font-semibold {{ $step['done'] ? 'text-[#2B3A8C]' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach

                    @if($surat->status === 'pending')
                    <div class="flex gap-3 pt-1">
                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center bg-yellow-100">
                            <svg class="w-3.5 h-3.5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="pt-1"><p class="text-xs font-semibold text-yellow-600">Pending oleh Kabag</p></div>
                    </div>
                    @elseif($surat->status === 'ditolak')
                    <div class="flex gap-3 pt-1">
                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center bg-red-100">
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div class="pt-1"><p class="text-xs font-semibold text-red-600">Ditolak</p></div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Log Persetujuan</h2>
                <div class="space-y-2">
                    @forelse($surat->persetujuan as $p)
                    <div class="p-3 bg-[#F8FAFF] rounded-xl">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-bold text-gray-700">
                                {{ ucfirst($p->role_approver) }}: {{ $p->user->nama_lengkap ?? '-' }}
                            </p>
                            <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold
                                {{ $p->status === 'disetujui' ? 'bg-green-100 text-green-700'
                                :($p->status === 'ditolak'  ? 'bg-red-100 text-red-700'
                                :($p->status === 'pending'  ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-gray-100 text-gray-500')) }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </div>
                        @if($p->catatan)
                        <p class="text-[10px] text-gray-500">{{ $p->catatan }}</p>
                        @endif
                        @if($p->approved_at)
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($p->approved_at)->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 italic text-center py-3">Belum ada log</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4">Riwayat Aktivitas</h2>
                <div class="space-y-0">
                    @forelse($surat->tracking as $track)
                    <div class="flex gap-3 pb-4 relative">
                        @if(!$loop->last)
                        <div class="absolute left-3.5 top-7 bottom-0 w-0.5 bg-gray-100"></div>
                        @endif
                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center z-10
                            {{ $loop->first ? 'bg-[#2B3A8C]' : 'bg-gray-100' }}">
                            <div class="w-2 h-2 rounded-full {{ $loop->first ? 'bg-white' : 'bg-gray-400' }}"></div>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-xs font-bold text-gray-700">{{ $track->aksi }}</p>
                            <p class="text-[10px] text-gray-400">{{ $track->user->nama_lengkap ?? '-' }}</p>
                            <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($track->created_at)->format('d/m/Y H:i') }}</p>
                            @if($track->keterangan)
                            <p class="text-xs text-gray-500 mt-1 bg-gray-50 rounded-lg px-2 py-1">{{ $track->keterangan }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<script>
let activeKategori = '';

function filterKategoriUnit(kategori) {
    activeKategori = kategori;
    applyUnitFilter();
}

function searchUnitHandler(val) {
    applyUnitFilter();
}

function applyUnitFilter() {
    const q    = document.getElementById('searchUnit').value.toLowerCase();
    const items = document.querySelectorAll('.unit-item');
    items.forEach(item => {
        const nama     = item.dataset.nama || '';
        const kategori = item.dataset.kategori || '';
        const matchQ   = !q || nama.includes(q);
        const matchK   = !activeKategori || kategori === activeKategori;
        item.style.display = (matchQ && matchK) ? '' : 'none';
    });
}

function updateSelectedTags() {
    const container = document.getElementById('selectedTags');
    container.innerHTML = '';
    document.querySelectorAll('.unit-checkbox:checked').forEach(cb => {
        const label    = cb.closest('label');
        const nama     = label.querySelector('p:first-child').textContent.trim();
        const tag      = document.createElement('span');
        tag.className  = 'inline-flex items-center gap-1 px-2.5 py-1 bg-[#2B3A8C] text-white text-xs font-semibold rounded-lg';
        tag.innerHTML  = nama + '<button type="button" onclick="removeTag(this,' + cb.value + ')" class="ml-1 hover:text-red-300 transition">×</button>';
        container.appendChild(tag);
    });
}

function removeTag(btn, val) {
    const cb = document.querySelector('.unit-checkbox[value="' + val + '"]');
    if (cb) {
        cb.checked = false;
        updateSelectedTags();
    }
}
function transferCatatan(form, fieldName) {
    const val    = document.getElementById('catatanApproval').value;
    const hidden = form.querySelector(`input[name="${fieldName}"]`);
    if (hidden) hidden.value = val;
    return true;
}

function transferCatatanDanUnit(form) {
    const val    = document.getElementById('catatanApproval').value;
    const hidden = form.querySelector('input[name="catatan"]');
    if (hidden) hidden.value = val;

    const container = document.getElementById('tagUnitsContainer');
    if (container) {
        container.innerHTML = '';
        document.querySelectorAll('.unit-checkbox:checked').forEach(cb => {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'tag_units[]';
            input.value = cb.value;
            container.appendChild(input);
        });
    }
    return true;
}
</script>

@endsection