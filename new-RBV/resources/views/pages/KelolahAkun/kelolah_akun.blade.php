@extends('layouts.app')

@section('content')
<div x-data="globalDeleteAkun()">
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                    <img src="{{ asset('images/kembali.svg') }}" class="w-6 h-6" fill=none  viewBox="0 0 24 24" stroke="currentColor">
                </a>
                <div>
                    <h1 class="font-poppins text-3xl sm:text-4xl font-extrabold text-[#2B3A8C] tracking-tight">Kelola Akun</h1>
                    <p class="text-gray-500 text-sm mt-1">Manajemen akun seluruh karyawan RS Citra Husada</p>
                </div>
            </div>
            <div class="flex items-center gap-3">

                <button onclick="document.getElementById('modalResetAll').classList.remove('hidden')"
                    class="flex items-center gap-2 px-5 py-3 bg-red-50 text-red-600 font-bold text-sm rounded-2xl
                           shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Reset Password Semua
                </button>

                <a href="{{ route('akun.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-white text-[#2B3A8C] font-bold text-sm rounded-2xl
                           shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Akun
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-5">
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-2xl px-5 py-3.5">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-semibold text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-5">
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-3.5">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-sm font-semibold text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16">
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 sm:p-8">

            <div class="mb-6">
                <form method="GET" action="{{ route('akun.index') }}">
                    <div class="flex flex-wrap gap-3">

                        <div class="flex flex-1 min-w-[200px] rounded-2xl overflow-hidden border border-gray-100 bg-[#F8FAFF]">
                            <div class="px-4 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama, NIK, jabatan, unit kerja..."
                                class="flex-1 py-3 pr-4 text-sm bg-transparent focus:outline-none text-gray-700 placeholder:text-gray-400">
                        </div>

                        <select name="role"
                            class="bg-[#F8FAFF] border border-gray-100 rounded-2xl py-3 px-5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <option value="">Semua Role</option>
                            <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin"       {{ request('role') == 'admin'       ? 'selected' : '' }}>Admin</option>
                            <option value="sekretaris"  {{ request('role') == 'sekretaris'  ? 'selected' : '' }}>Sekretaris</option>
                            <option value="karyawan"    {{ request('role') == 'karyawan'    ? 'selected' : '' }}>Karyawan</option>
                            <option value="unit"        {{ request('role') == 'unit'        ? 'selected' : '' }}>Unit</option>
                        </select>

                        <button type="submit"
                            class="px-8 py-3 bg-[#2B3A8C] text-white text-sm font-bold rounded-2xl
                                   hover:bg-blue-800 transition shadow-lg shadow-blue-100">
                            Cari
                        </button>

                        @if(request()->hasAny(['search','role']))
                        <a href="{{ route('akun.index') }}"
                            class="px-5 py-3 bg-gray-100 text-gray-600 text-sm font-bold rounded-2xl hover:bg-gray-200 transition">
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-50 text-xs uppercase tracking-widest">
                            <th class="text-left px-4 py-4 font-bold">NIK</th>
                            <th class="text-left px-4 py-4 font-bold">Nama Lengkap</th>
                            <th class="text-left px-4 py-4 font-bold">Jabatan</th>
                            <th class="text-left px-4 py-4 font-bold">Unit Kerja</th>
                            <th class="text-left px-4 py-4 font-bold">Role</th>
                            <th class="text-center px-4 py-4 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $akun)
                        <tr class="hover:bg-[#F8FAFF] transition
                            {{ $akun->id_user === auth()->user()->id_user ? 'bg-blue-50/30' : '' }}">

                            <td class="px-4 py-4 font-mono text-xs text-gray-500">{{ $akun->NIK }}</td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#2B3A8C] flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xs font-bold">
                                            {{ strtoupper(substr($akun->nama_lengkap, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-700">{{ $akun->nama_lengkap }}</p>
                                        @if($akun->id_user === auth()->user()->id_user)
                                        <span class="text-[10px] text-[#2B3A8C] font-semibold">— Akun kamu</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-xs text-gray-600">{{ $akun->jabatan ?? '-' }}</td>

                            <td class="px-4 py-4 text-xs text-gray-600">{{ $akun->unit_kerja ?? '-' }}</td>

                            <td class="px-4 py-4">
                                @php
                                    $roleConfig = [
                                        'super_admin' => ['bg-purple-100 text-purple-700', 'Super Admin'],
                                        'admin'       => ['bg-blue-100 text-blue-700',     'Admin'],
                                        'sekretaris'  => ['bg-indigo-100 text-indigo-700', 'Sekretaris'],
                                        'karyawan'    => ['bg-gray-100 text-gray-600',     'Karyawan'],
                                        'unit'        => ['bg-green-100 text-green-700',   'Unit'],
                                    ];
                                    [$cls, $lbl] = $roleConfig[$akun->role] ?? ['bg-gray-100 text-gray-500', ucfirst($akun->role)];
                                @endphp
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-bold {{ $cls }}">
                                    {{ $lbl }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('akun.edit', $akun->id_user) }}"
                                        class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                                        <img src="{{ asset('images/Edit.svg') }}" class="w-5 h-5 object-contain">
                                    </a>

                                    @if($akun->id_user !== auth()->user()->id_user)
                                    <button @click="openDeleteModal({{ $akun->id_user }}, '{{ addslashes($akun->nama_lengkap) }}')"
                                        class="p-1.5 bg-red-600 text-white rounded-lg shadow hover:scale-110 transition">
                                        <img src="{{ asset('images/Delete.svg') }}" class="w-5 h-5 object-contain">
                                    </button>
                                    @else
                                    <div class="p-1.5 bg-gray-100 text-gray-300 rounded-lg cursor-not-allowed" title="Tidak bisa hapus akun sendiri">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </div>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-20 text-center text-gray-400 italic">
                                Tidak ada akun ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="mt-8 pt-6 border-t border-gray-50">
                {{ $users->links() }}
            </div>
            @endif

        </div>
    </div>
</div>

<template x-if="openDelete">
    <div @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Hapus Akun</h2>
            <p class="text-gray-500 mb-2">Apa anda yakin ingin menghapus akun</p>
            <p class="font-bold text-[#2B3A8C] mb-8" x-text="selectedName"></p>
            <div class="flex gap-4">
                <button @click="closeModal()"
                    class="bg-gray-400 text-white font-bold py-3 rounded-xl w-full">
                    Tidak
                </button>
                <form :action="'/akun/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white font-bold py-3 rounded-xl w-full">
                        Ya
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

</div>

<div id="modalResetAll" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         onclick="document.getElementById('modalResetAll').classList.add('hidden')"></div>

    <div class="relative z-10 w-full max-w-md mx-4 bg-white rounded-2xl shadow-2xl p-6 sm:p-8">

        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-poppins font-bold text-gray-800 text-lg">Reset Password Semua Akun</h2>
                <p class="text-xs text-gray-400">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-5">
            <p class="text-xs text-red-700 font-semibold">
                ⚠️ Seluruh akun karyawan (kecuali akun kamu) akan berganti password sesuai yang kamu isi.
            </p>
        </div>

        <form action="{{ route('akun.reset-all-password') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-xs text-gray-500 mb-1.5 ml-1 font-semibold">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password_baru" id="passwordBaru"
                        placeholder="Masukkan password baru..." required minlength="6"
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 pr-10 text-sm
                               focus:outline-none focus:ring-2 focus:ring-red-400">
                    <button type="button" onclick="toggleModalPw()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="modalEye" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 ml-1">Minimal 6 karakter</p>
            </div>

            <div id="step1" class="grid grid-cols-2 gap-3">
                <button type="button"
                    onclick="document.getElementById('modalResetAll').classList.add('hidden')"
                    class="py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="button" onclick="showKonfirmasi()"
                    class="py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition">
                    Lanjut
                </button>
            </div>

            <div id="step2" class="hidden">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-4">
                    <p class="text-xs text-yellow-700 font-semibold text-center">
                        Apakah kamu yakin ingin mereset password seluruh akun?
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="hideKonfirmasi()"
                        class="py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">
                        Tidak
                    </button>
                    <button type="submit"
                        class="py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition">
                        Ya, Reset Semua
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
function globalDeleteAkun() {
    return {
        openDelete: false,
        selectedId: null,
        selectedName: '',
        openDeleteModal(id, name) {
            this.selectedId   = id;
            this.selectedName = name;
            this.openDelete   = true;
        },
        closeModal() {
            this.openDelete   = false;
            this.selectedId   = null;
            this.selectedName = '';
        }
    }
}

function showKonfirmasi() {
    const pw = document.getElementById('passwordBaru').value;
    if (!pw || pw.length < 6) {
        alert('Password minimal 6 karakter.');
        return;
    }
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.remove('hidden');
}
function hideKonfirmasi() {
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step1').classList.remove('hidden');
}
function toggleModalPw() {
    const input = document.getElementById('passwordBaru');
    const icon  = document.getElementById('modalEye');
    if (input.type === 'password') {
        input.type     = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>';
    } else {
        input.type     = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>

@endsection