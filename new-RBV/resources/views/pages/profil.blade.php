@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-6">
        
        <div class="bg-white rounded-[30px] shadow-2xl p-10 md:p-14 border border-gray-50 relative">
            
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-[#2B3A8C] mb-1">Profil</h1>
                <p class="text-gray-400 text-sm">Informasi data akun</p>
            </div>

            <div class="space-y-5">

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Nama</label>
                    <input type="text" value="{{ session('user_name') }}" disabled
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">NIK</label>
                    <input type="text" value="{{ session('user_nik') }}" disabled
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Jabatan</label>
                    <input type="text" value="{{ session('user_jabatan') }}" disabled
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Unit Kerja</label>
                    <input type="text" value="{{ session('user_unit') }}" disabled
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Role</label>
                    <input type="text" value="{{ session('user_role') }}" disabled
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>
            </div>

            <div x-data="{ openLogout: false }">

                <div class="flex justify-center mt-12">
                    <button @click="openLogout = true" type="button" 
                            class="bg-[#2B3A8C] text-white font-bold py-3 px-16 rounded-xl hover:bg-blue-900 transition shadow-lg">
                        Logout
                    </button>
                </div>

                <div x-show="openLogout" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
                    
                    <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center" @click.away="openLogout = false">
                        
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Logout Akun</h2>
                        <p class="text-gray-500 mb-8">Apa anda yakin ingin Logout?</p>

                        <div class="flex gap-10 justify-between">
                            <button @click="openLogout = false" 
                                    class="bg-gray-400 text-white font-bold py-3 px-3 rounded-xl hover:bg-gray-500 transition w-full">
                                Tidak
                            </button>

                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                        class="bg-[#E12028] text-white font-bold py-3 px-10 rounded-xl hover:bg-red-700 transition w-full">
                                    Ya
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        </div>
    </div>
</div>
@endsection