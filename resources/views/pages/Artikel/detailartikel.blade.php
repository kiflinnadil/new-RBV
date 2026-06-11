@extends('layouts.app')

@section('content')

<div class="px-16 py-16" >

    <div class="bg-white rounded-2xl shadow-lg p-10 grid md:grid-cols-2 gap-12">

        <div>
            <img src="{{ asset('images/'.$artikel->cover) }}"
                    class="rounded-xl shadow-md w-full object-cover">
        </div>

        <div class="flex flex-col justify-between">

            <div>
                <h1 class="text-4xl font-bold text-[#2B3A8C] mb-1">
                    {{ $artikel->judul }}
                </h1>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        {{ $artikel->deskripsi }}
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
