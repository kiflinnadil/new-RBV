@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-4xl mx-auto px-6">
            
            <h1 class="text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                Upload Buku
            </h1>

            <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Judul Buku</label>
                            <input type="text" name="judul" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan judul buku">
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Pengarang</label>
                            <input type="text" name="pengarang" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan nama pengarang">
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan tahun terbit">
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan deskripsi buku"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">
                                File Buku
                            </label>

                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <span class="block text-gray-400 text-sm ml-1 italic">
                                    File maksimal 20 MB
                                </span>
                                <input type="file" class="hidden">
                            </label>
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">
                                Cover Photo
                            </label>

                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <span class="block text-gray-400 text-sm ml-1 italic">
                                    File maksimal 20 MB
                                </span>
                                <input type="file" class="hidden">
                            </label>
                        </div>


                        {{-- <div class="col-span-full">
                            <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">File Buku</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                    <div class="text-center">
                                        <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="mx-auto size-12 text-gray-300">
                                            <path d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm/6 text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-600 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-indigo-600 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="file-upload" type="file" name="file-upload" class="sr-only" />
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-span-full">
                            <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                    <div class="text-center">
                                        <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="mx-auto size-12 text-gray-300">
                                            <path d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm/6 text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-600 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-indigo-600 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="file-upload" type="file" name="file-upload" class="sr-only" />
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit" 
                                class="bg-[#2B3A8C] text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection