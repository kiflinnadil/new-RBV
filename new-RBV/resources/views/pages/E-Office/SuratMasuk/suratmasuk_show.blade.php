@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12"">

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
                    <p class="font-mono text-xm text-gray-400">{{ $surat->nomor_agenda }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('eoffice.surat-masuk.export-pdf', $surat->id) }}"
                    class="flex items-center gap-2 px-6 py-3 bg-white text-red-600 font-bold text-sm rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>PDF</span>
                </a>
            </div>
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
                        @else
                            <span class="text-xs px-2 py-1 rounded-lg font-semibold bg-green-100 text-green-700">🟢 Biasa</span>
                        @endif
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
            </div>

            @if($surat->tags->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Penerima Surat</h2>
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

            @php
                $myRole = auth()->user()->role;
                $roleApprover = match($myRole){ 'super_admin'=>'direktur','kabag'=>'kabag',default=>null };
                $myPersetujuan = $roleApprover
                    ? $surat->persetujuan->where('role_approver',$roleApprover)->first()
                    : null;
                $bisaApprove = $myPersetujuan && $myPersetujuan->status === 'menunggu'
                    && in_array($surat->status,['menunggu_direktur','menunggu_kabag']);
            @endphp

            @if($bisaApprove)
            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-5 sm:p-6">
                <h2 class="font-poppins font-bold text-yellow-700 text-sm mb-4">
                    Tindakan Persetujuan — Anda ({{ ucfirst($roleApprover) }})
                </h2>

                <form action="{{ route('eoffice.surat-masuk.setujui', $surat->id) }}" method="POST" class="mb-3">
                    @csrf
                    <textarea name="catatan" rows="2" placeholder="Catatan persetujuan (opsional)..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 resize-none mb-3"></textarea>
                    <button type="submit"
                        class="w-full py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition">
                        ✅ Setujui Surat
                    </button>
                </form>

                <form action="{{ route('eoffice.surat-masuk.tolak', $surat->id) }}" method="POST">
                    @csrf
                    <textarea name="catatan_tolak" rows="2" placeholder="Alasan penolakan (wajib diisi)..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none mb-3"
                        required></textarea>
                    <button type="submit"
                        class="w-full py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition">
                        ❌ Tolak Surat
                    </button>
                </form>
            </div>
            @endif

        </div>

        <div class="space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Status Surat</h2>
                @php
                    $statusConfig = [
                        'menunggu'           => ['bg-gray-100',   'text-gray-600',  'Menunggu'],
                        'menunggu_direktur'  => ['bg-yellow-100', 'text-yellow-700','Menunggu Direktur'],
                        'menunggu_kabag'     => ['bg-orange-100', 'text-orange-700','Menunggu Kabag'],
                        'disetujui'          => ['bg-green-100',  'text-green-700', 'Disetujui'],
                        'ditolak'            => ['bg-red-100',    'text-red-700',   'Ditolak'],
                    ];
                    [$bg, $tc, $label] = $statusConfig[$surat->status] ?? ['bg-gray-100','text-gray-600','—'];
                @endphp
                <div class="flex items-center gap-2 p-3 {{ $bg }} rounded-xl">
                    <div class="w-2.5 h-2.5 rounded-full {{ $tc === 'text-green-700' ? 'bg-green-500' : ($tc === 'text-red-700' ? 'bg-red-500' : 'bg-yellow-500') }}
                        {{ $surat->status === 'menunggu_direktur' || $surat->status === 'menunggu_kabag' ? 'animate-pulse' : '' }}"></div>
                    <span class="text-sm font-semibold {{ $tc }}">{{ $label }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4">Alur Persetujuan</h2>
                @php
                    $steps = [
                        ['label'=>'Diterima Sekretaris', 'done'=>true],
                        ['label'=>'Menunggu Direktur',   'done'=>in_array($surat->status,['menunggu_kabag','disetujui','ditolak'])],
                        ['label'=>'Disetujui Direktur',  'done'=>in_array($surat->status,['menunggu_kabag','disetujui'])],
                        ['label'=>'Menunggu Kabag',      'done'=>in_array($surat->status,['disetujui','ditolak']) && $surat->persetujuan->where('role_approver','kabag')->first()?->status !== 'menunggu'],
                        ['label'=>'Selesai',             'done'=>$surat->status === 'disetujui'],
                    ];
                    if ($surat->status === 'ditolak') {
                        $steps = array_map(fn($s) => array_merge($s,['tolak'=>true]), $steps);
                    }
                @endphp
                <div class="space-y-0">
                    @foreach($steps as $i => $step)
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
                    @if($surat->status === 'ditolak')
                    <div class="flex gap-3 pt-1">
                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center bg-red-100">
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div class="pt-1">
                            <p class="text-xs font-semibold text-red-600">Ditolak</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Log Persetujuan</h2>
                <div class="space-y-2">
                    @foreach($surat->persetujuan as $p)
                    <div class="p-3 bg-[#F8FAFF] rounded-xl">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-bold text-gray-700">{{ ucfirst($p->role_approver) }}: {{ $p->user->nama_lengkap ?? '-' }}</p>
                            <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold
                                {{ $p->status === 'disetujui' ? 'bg-green-100 text-green-700' : ($p->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
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
                    @endforeach
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
@endsection