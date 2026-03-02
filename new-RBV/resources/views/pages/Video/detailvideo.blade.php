@extends('layouts.app')

@section('content')

<div class="px-16 py-16">

    <div class="bg-white rounded-2xl shadow-lg p-10 grid md:grid-cols-2 gap-12">

        <div>
            <iframe src="{{ $video->link }}" class="w-full h-56"></iframe>
        </div>

        <div>

            <a href="{{ route('books.index') }}"
               class="inline-block mt-8 bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                ← Kembali
            </a>

        </div>

    </div>

</div>

@endsection