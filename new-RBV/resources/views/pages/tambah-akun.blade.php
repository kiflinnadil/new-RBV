@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-6">

        <form action="{{ route('akun.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-[30px] shadow-2xl p-10 md:p-14 border border-gray-50">

                <div class="text-center mb-10">
                    <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] mb-10">
                        Tambah Akun
                    </h1>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-5">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-5">

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">NIK</label>
                        <input type="text" name="NIK"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Jabatan</label>
                        <input type="text" name="jabatan"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Unit Kerja</label>
                        <input type="text" name="unit_kerja"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Role</label>
                        <select name="role"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                            <option value="">Pilih Role</option>
                            <option value="admin">admin</option>
                            <option value="sekretaris">sekretaris</option>
                            <option value="karyawan">karyawan</option>
                            <option value="unit">unit</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Password</label>
                        <input type="password" name="password"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm mb-1 ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">
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
@endsection