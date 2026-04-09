@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-6">
        <div class="mb-6">
            <a href="/"
            class="inline-flex items-center justify-center w-10 h-10 rounded-full
                    text-gray-400 hover:text-[#2B3A8C] hover:bg-blue-50 transition-all duration-200 -ml-50 -mt-10">
                <img src="{{ asset('images/kembali.svg') }}" class="w-6 h-6" fill=none  viewBox="0 0 24 24" stroke="currentColor">
            </a>
        </div>
        <div class="bg-white rounded-[30px] shadow-2xl p-10 md:p-14 border border-gray-50 relative">
            
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-[#2B3A8C] mb-1">Profil</h1>
                <p class="text-gray-400 text-sm">Informasi data akun</p>
            </div>

            <div class="space-y-5">

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Nama</label>
                    <input type="text" value="{{ auth()->user()->nama_lengkap }}" disabled
                    class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">NIK</label>
                    <input type="text" value="{{ auth()->user()->NIK }}" disabled
                    class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Jabatan</label>
                    <input type="text" value="{{ auth()->user()->jabatan }}" disabled
                    class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Unit Kerja</label>
                    <input type="text" value="{{ auth()->user()->unit_kerja }}" disabled
                    class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Role</label>
                    <input type="text" value="{{ auth()->user()->role }}" disabled
                    class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>
            </div>

            <div x-data="logoutModal()" x-init="init()" x-cloak>

                <div class="flex justify-center mt-12">
                    <button @click="openLogout = true"
                        class="bg-[#2B3A8C] text-white font-bold py-3 px-16 rounded-xl hover:bg-blue-900 transition shadow-lg">
                        Logout
                    </button>
                </div>

                <div x-show="openLogout"
                    @click.self="openLogout = false"
                    x-transition
                    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

                    <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">

                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Logout Akun</h2>
                        <p class="text-gray-500 mb-8">Apa anda yakin ingin Logout?</p>

                        <div class="flex gap-4">
                            <button @click="openLogout = false"
                                class="bg-gray-400 text-white font-bold py-3 rounded-xl w-full">
                                Tidak
                            </button>

                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 text-white font-bold py-3 rounded-xl w-full">
                                    Ya
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
function logoutModal() {
    return {
        openLogout: false,
        init() {
            this.openLogout = false
        }
    }
}
</script>
@endsection