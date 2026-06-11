@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    <div class="max-w-3xl mx-auto px-4 sm:px-8">

        <div class="mb-8">
            <h1 class="font-poppins text-3xl sm:text-4xl font-extrabold text-[#2B3A8C] tracking-tight">
                Backup Database
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Export dan import data database sistem
            </p>
        </div>

        @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-2xl px-5 py-3.5 mb-5">
            <div class="w-2.5 h-2.5 rounded-full bg-green-400 flex-shrink-0"></div>
            <p class="text-sm font-semibold text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-3.5 mb-5">
            <div class="w-2.5 h-2.5 rounded-full bg-red-400 flex-shrink-0"></div>
            <p class="text-sm font-semibold text-red-700">{{ session('error') }}</p>
        </div>
        @endif

        <div class="space-y-5">

            {{-- EXPORT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#2B3A8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="font-poppins font-bold text-gray-800 text-base mb-1">Export Backup</h2>
                        <p class="text-gray-500 text-sm mb-5">
                            Download seluruh data database dalam format file backup. Simpan file ini di tempat yang aman.
                        </p>
                        <form action="{{ route('backup.export') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-[#2B3A8C] text-white text-sm font-bold rounded-2xl
                                       hover:bg-blue-900 hover:shadow-lg hover:shadow-blue-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Backup
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- IMPORT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="font-poppins font-bold text-gray-800 text-base mb-1">Import Backup</h2>
                        <p class="text-gray-500 text-sm mb-5">
                            Pulihkan data dari file backup sebelumnya. 
                            <span class="text-red-500 font-semibold">Perhatian: proses ini akan menimpa data yang ada saat ini.</span>
                        </p>
                        <form action="{{ route('backup.import') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <div class="relative group">
                                    <input type="file"
                                           name="backup_file"
                                           id="backupFile"
                                           required
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6
                                                flex flex-col items-center justify-center group-hover:border-green-400 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-8 h-8 text-gray-400 group-hover:text-green-500 mb-2"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/>
                                        </svg>
                                        <span id="fileLabel" class="text-xs text-gray-500 group-hover:text-green-600">
                                            Klik atau tarik file backup ke sini
                                        </span>
                                        <span class="text-[10px] text-gray-400 mt-1">Format: .sql / .zip</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                onclick="return confirm('Yakin ingin import? Data saat ini akan tertimpa.')"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white text-sm font-bold rounded-2xl
                                       hover:bg-green-700 hover:shadow-lg hover:shadow-green-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12"/>
                                </svg>
                                Import Backup
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- INFO --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-yellow-700 mb-1">Catatan Penting</p>
                        <ul class="text-xs text-yellow-600 space-y-1">
                            <li>• Lakukan backup secara berkala, minimal seminggu sekali</li>
                            <li>• Simpan file backup di lokasi yang aman dan terpisah dari server</li>
                            <li>• Pastikan file backup valid sebelum melakukan import</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('backupFile').addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (f) {
        document.getElementById('fileLabel').textContent = f.name;
    }
});
</script>

@endsection