@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('eoffice.surat-masuk.index') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                @if(auth()->user()->jabatan === 'kabag')
                    <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">Acc Surat Pending</h1>
                @else
                    <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">Proses Surat Masuk</h1>
                @endif
                <p class="font-mono text-sm text-gray-400">{{ $surat->nomor_agenda }}</p>
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
                        <p class="text-xs text-gray-400 mb-0.5">Pengirim</p>
                        <p class="font-semibold text-gray-700">
                            {{ $surat->pembuat->nama_lengkap ?? '-' }}
                            <span class="text-gray-400 font-normal text-xs">({{ $surat->pembuat->unit_kerja ?? '' }})</span>
                        </p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->jabatan === 'kabag')

            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-5 sm:p-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                    <h2 class="font-poppins font-bold text-yellow-700 text-sm">Surat Pending — Tindakan Kabag</h2>
                </div>
                <p class="text-xs text-gray-400 mb-5 ml-4">Surat ini sebelumnya ditandai pending. Kamu bisa menyetujui atau menolaknya.</p>

                <form action="{{ route('eoffice.surat-masuk.update', $surat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="aksi_kabag" value="1">

                    <div class="mb-5">
                        <label class="block text-xs text-gray-500 mb-1.5 ml-1">Catatan</label>
                        <textarea name="catatan" rows="3"
                            placeholder="Tulis catatan persetujuan atau penolakan..."
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" name="status_baru" value="ditolak"
                            onclick="return confirm('Tolak surat ini?')"
                            class="py-3 bg-red-600 text-white text-sm font-bold rounded-xl
                                   hover:bg-red-700 transition flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak
                        </button>
                        <button type="submit" name="status_baru" value="disetujui"
                            class="py-3 bg-green-600 text-white text-sm font-bold rounded-xl
                                   hover:bg-green-700 transition flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setuju
                        </button>
                    </div>

                    <a href="{{ route('eoffice.surat-masuk.index') }}"
                        class="block text-center text-xs text-gray-400 hover:text-gray-600 mt-4 transition">
                        Batal, kembali ke daftar
                    </a>

                </form>
            </div>

            @else

            <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-5 sm:p-6">

                <div class="flex items-center gap-2 mb-5">
                    <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                    <h2 class="font-poppins font-bold text-[#2B3A8C] text-sm">
                        Proses & Teruskan ke Direktur
                    </h2>
                </div>

                <form action="{{ route('eoffice.surat-masuk.update', $surat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-xs text-gray-500 mb-1.5 ml-1">
                            Set Prioritas <span class="text-red-500">*</span>
                        </label>
                        <select name="prioritas" required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <option value="biasa"  {{ old('prioritas') == 'biasa'  ? 'selected' : '' }}>🟢 Biasa</option>
                            <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                            <option value="segera" {{ old('prioritas') == 'segera' ? 'selected' : '' }}>🔴 Segera</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs text-gray-500 mb-1.5 ml-1">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="3"
                            placeholder="Tambahkan catatan untuk direktur..."
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs text-gray-500 mb-2 ml-1 font-bold">
                            Disposisi ke <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-blue-50 p-4 rounded-2xl border border-blue-100">
                            @foreach($usersTag as $u)
                            <label class="flex items-center gap-3 cursor-pointer group p-2.5 rounded-xl hover:bg-blue-100 transition">
                                <input type="checkbox" name="tag_users[]" value="{{ $u->id_user }}"
                                    class="w-4 h-4 rounded border-gray-300 text-[#2B3A8C] focus:ring-[#2B3A8C]">
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 group-hover:text-[#2B3A8C]">{{ $u->nama_lengkap }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $u->jabatan }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('tag_users')
                        <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                        <p class="text-[10px] text-gray-400 mt-1.5 ml-1">*Pilih minimal satu untuk diteruskan</p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('eoffice.surat-masuk.index') }}"
                            class="flex-1 py-3 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl
                                   hover:bg-gray-200 transition text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 py-3 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl
                                   hover:bg-blue-900 hover:shadow-lg hover:shadow-blue-200 transition">
                            Teruskan ke Direktur →
                        </button>
                    </div>

                </form>
            </div>

            @endif

        </div>

        <div class="space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">Status Surat</h2>
                <div class="flex items-center gap-2 p-3 bg-orange-100 rounded-xl">
                    <div class="w-2.5 h-2.5 rounded-full bg-orange-400 animate-pulse flex-shrink-0"></div>
                    <span class="text-sm font-semibold text-orange-700">⏳ Menunggu Diproses</span>
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