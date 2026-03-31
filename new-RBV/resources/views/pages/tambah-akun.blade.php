@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-6">

        <form action="{{ route('akun.store') }}" method="POST" id="formTambahAkun">
            @csrf

            <div class="bg-white rounded-[30px] shadow-2xl p-10 md:p-14 border border-gray-50">

                <div class="text-center mb-10">
                    <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] mb-10">
                        Tambah Akun
                    </h1>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">NIK</label>
                        <input type="text" name="NIK" value="{{ old('NIK') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Unit Kerja</label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Role</label>
                        <div class="relative">
                            <select name="role"
                                class="w-full appearance-none bg-[#F3F4F6] rounded-xl
                                       py-3 pl-5 pr-10 text-gray-700
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                                <option value="">Pilih Role</option>

                                <option value="admin"      {{ old('role') == 'admin'      ? 'selected' : '' }}>Admin</option>
                                <option value="sekretaris" {{ old('role') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                <option value="karyawan"   {{ old('role') == 'karyawan'   ? 'selected' : '' }}>Karyawan</option>
                                <option value="unit"       {{ old('role') == 'unit'       ? 'selected' : '' }}>Unit</option>
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                autocomplete="new-password"
                                oninput="checkPasswordMatch()"
                                class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 pr-12
                                       [&::-ms-reveal]:hidden [&::-ms-clear]:hidden
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <button type="button" onclick="togglePassword('password','eye-1')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition p-0.5">
                                <svg id="eye-1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.584 10.587a2 2 0 002.828 2.83M6.363 6.365C4.31 7.63 2.726 9.65 2 12c1.274 4.057 5.065 7 9.542 7 1.99 0 3.842-.574 5.393-1.563M9.032 4.18A10.16 10.16 0 0112 4c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-1.888 3.308"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                autocomplete="new-password"
                                oninput="checkPasswordMatch()"
                                class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 pr-12
                                       [&::-ms-reveal]:hidden [&::-ms-clear]:hidden
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <button type="button" onclick="togglePassword('password_confirmation','eye-2')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition p-0.5">
                                <svg id="eye-2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path class="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    <path class="eye-closed hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.584 10.587a2 2 0 002.828 2.83M6.363 6.365C4.31 7.63 2.726 9.65 2 12c1.274 4.057 5.065 7 9.542 7 1.99 0 3.842-.574 5.393-1.563M9.032 4.18A10.16 10.16 0 0112 4c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-1.888 3.308"/>
                                </svg>
                            </button>
                        </div>

                        <div id="msg-error" class="hidden mt-2 px-4 py-2.5 bg-red-100 text-red-700 rounded-xl flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Password dan konfirmasi password tidak cocok.
                        </div>

                        <div id="msg-ok" class="hidden mt-2 px-4 py-2.5 bg-green-100 text-green-700 rounded-xl flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Password cocok.
                        </div>
                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit"
                            class="bg-[#2B3A8C] text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition">
                            Simpan
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

<script>
function togglePassword(inputId, svgId) {
    const input      = document.getElementById(inputId);
    const svg        = document.getElementById(svgId);
    const openPaths  = svg.querySelectorAll('.eye-open');
    const closedPath = svg.querySelector('.eye-closed');
    if (input.type === 'password') {
        input.type = 'text';
        openPaths.forEach(p => p.classList.add('hidden'));
        closedPath.classList.remove('hidden');
    } else {
        input.type = 'password';
        openPaths.forEach(p => p.classList.remove('hidden'));
        closedPath.classList.add('hidden');
    }
}

function checkPasswordMatch() {
    const pw      = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const errDiv  = document.getElementById('msg-error');
    const okDiv   = document.getElementById('msg-ok');
    const cfInput = document.getElementById('password_confirmation');

    if (confirm === '') {
        errDiv.classList.add('hidden');
        okDiv.classList.add('hidden');
        cfInput.classList.remove('ring-2','ring-red-400','ring-green-400');
        return;
    }
    if (pw !== confirm) {
        errDiv.classList.remove('hidden');
        okDiv.classList.add('hidden');
        cfInput.classList.add('ring-2','ring-red-400');
        cfInput.classList.remove('ring-green-400');
    } else {
        errDiv.classList.add('hidden');
        okDiv.classList.remove('hidden');
        cfInput.classList.add('ring-2','ring-green-400');
        cfInput.classList.remove('ring-red-400');
    }
}

document.getElementById('formTambahAkun').addEventListener('submit', function (e) {
    const pw      = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    if (pw !== confirm) {
        e.preventDefault();
        document.getElementById('msg-error').classList.remove('hidden');
        document.getElementById('msg-ok').classList.add('hidden');
        document.getElementById('password_confirmation').focus();
    }
});
</script>

@endsection