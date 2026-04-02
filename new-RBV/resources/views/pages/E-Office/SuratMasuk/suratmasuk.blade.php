@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-poppins text-3xl sm:text-5xl font-extrabold text-[#2B3A8C] tracking-tight">Surat Masuk</h1>
                <p class="text-gray-500 text-sm sm:text-base mt-1">Daftar arsip dan monitoring surat masuk</p>
            </div>
            
            <div class="flex items-center gap-3">

                <a href="{{ route('eoffice.surat-masuk.export') }}" 
                    class="flex items-center gap-2 px-5 py-3 bg-white text-green-600 font-bold text-sm rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Export</span>
                </a>

                @auth
                @if(in_array(auth()->user()->role, ['super_admin','admin','sekretaris']))
                <a href="{{ route('eoffice.surat-masuk.create') }}" 
                    class="flex items-center gap-2 px-5 py-3 bg-white text-[#2B3A8C] font-bold text-sm rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Surat</span>
                </a>
                @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16">
        
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 sm:p-8">
            
            <div class="mb-8">
                <form method="GET" action="{{ route('eoffice.surat-masuk.index') }}">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor agenda / perihal / asal surat..."
                            class="flex-1 bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3.5 px-6 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] transition">

                        <div class="flex gap-4">
                            <select name="prioritas" class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3.5 px-6 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                                <option value="">Semua Prioritas</option>
                                <option value="segera">🔴 Segera</option>
                                <option value="sedang">🟡 Sedang</option>
                                <option value="biasa">🟢 Biasa</option>
                            </select>

                            <button type="submit" class="px-10 py-3.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-2xl hover:bg-blue-800 transition shadow-lg shadow-blue-100">
                                Cari
                            </button>
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
                            <th class="text-left px-4 py-4 font-bold">Perihal</th>
                            <th class="text-left px-4 py-4 font-bold">Prioritas</th>
                            <th class="text-left px-4 py-4 font-bold">Status</th>
                            <th class="text-center px-4 py-4 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($suratMasuk as $surat)
                        <tr class="hover:bg-[#F8FAFF] transition group">
                            <td class="px-4 py-5 font-mono font-bold text-[#2B3A8C]">{{ $surat->nomor_agenda }}</td>
                            <td class="px-4 py-5 text-gray-700 font-medium">{{ $surat->asal_surat }}</td>
                            <td class="px-4 py-5 text-gray-500 max-w-xs truncate">{{ $surat->perihal }}</td>
                            <td class="px-4 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                                    {{ $surat->prioritas == 'segera' ? 'bg-red-100 text-red-600' : ($surat->prioritas == 'sedang' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600') }}">
                                    {{ strtoupper($surat->prioritas) }}
                                </span>
                            </td>
                            <td class="px-4 py-5 text-xs font-semibold text-gray-400 capitalize">{{ str_replace('_', ' ', $surat->status) }}</td>
                            <td class="px-4 py-5 text-center">
                                <a href="{{ route('eoffice.surat-masuk.show', $surat->id) }}" class="inline-block p-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-[#2B3A8C] hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-20 text-center text-gray-400">Belum ada data surat masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suratMasuk->hasPages())
            <div class="mt-8 pt-6 border-t border-gray-50">{{ $suratMasuk->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection