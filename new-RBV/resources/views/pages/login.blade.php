@extends('layouts.app')

@section('content')

<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-2xl shadow-lg">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
            Login
        </h1>
        <p class="text-lg text-gray-600 mb-6">
            Gunakan akun anda untuk masuk
        </p>
        
        <form class="space-y-4">
            <input type="text" name="nik" placeholder="NIK"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit"
                class="w-full bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">
                Login
            </button>
        </form>
    </div>

    <a href="/register"
        class="mt-6 text-blue-700 hover:text-blue-900 transition">
        Daftar Sekarang
    </a>

</div>

@endsection