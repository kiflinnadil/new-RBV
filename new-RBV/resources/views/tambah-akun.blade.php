@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-6">

        
        
        <div class="bg-white rounded-[30px] shadow-2xl p-10 md:p-14 border border-gray-50 relative">
            
            <div class="text-center mb-10">
                <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                    Tambah Akun
                </h1>
            </div>

            <div class="space-y-5">

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">NIK</label>
                    <input type="text"
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Password</label>
                    <input type="text" name="password"
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-sm mb-1 ml-1">Konfirmasi Password</label>
                    <input type="text" name=""
                        class="w-full bg-[#F3F4F6] border-none rounded-xl py-3 px-5 text-gray-600 outline-none">
                </div>

                <div class="flex justify-center mt-10">
                    <button type="submit" 
                            class="bg-[#2B3A8C] font-poppins text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        simpan
                    </button>
                </div>

                
            </div>


        </div>
    </div>
</div>
@endsection