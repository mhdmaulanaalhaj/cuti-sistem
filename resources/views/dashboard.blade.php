@extends('layouts.app')

@section('header')
    {{-- Kosongkan supaya header "Dashboard" tidak ganda --}}
@endsection

@section('content')
    @php
        date_default_timezone_set('Asia/Jakarta');
        $hour = date('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Siang';
        } else {
            $greeting = 'Selamat Malam';
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    HALO {{ Auth::user()->name }}, {{ $greeting }} 🎉
                </h1>
                <p class="text-gray-600 mb-6">Selamat datang di Dashboard Aplikasi Cuti & Request Barang.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form Cuti -->
                    <a href="{{ url('/cuti') }}" 
                       class="block p-6 rounded-lg bg-blue-100 hover:bg-blue-200 border border-blue-300 shadow text-center transition duration-200">
                        <h2 class="text-lg font-semibold text-blue-800">Form Pengajuan Cuti</h2>
                        <p class="text-sm text-blue-600 mt-2">Ajukan cuti dengan mudah dan cepat</p>
                    </a>

                    <!-- Form Request Barang -->
                    <a href="{{ url('/requests') }}" 
                       class="block p-6 rounded-lg bg-green-100 hover:bg-green-200 border border-green-300 shadow text-center transition duration-200">
                        <h2 class="text-lg font-semibold text-green-800">Form Request Barang</h2>
                        <p class="text-sm text-green-600 mt-2">Buat permintaan barang baru atau restock</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
