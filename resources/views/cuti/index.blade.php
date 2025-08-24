@extends('layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Pengajuan Cuti Saya
            </h2>
        </div>
    </header>
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

        @if(session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h3 class="font-semibold">Pengajuan Cuti</h3>
            <a href="{{ route('cuti.create') }}"
               class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
               + Ajukan Cuti
            </a>
        </div>

        @if($cutis->isEmpty())
            <p class="text-gray-600 mt-4">Belum ada pengajuan cuti.</p>
        @else
            <table class="w-full mt-4 text-sm text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Tanggal Mulai</th>
                        <th class="p-2 border">Tanggal Selesai</th>
                        <th class="p-2 border">Alasan</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cutis as $c)
                        <tr>
                            <td class="p-2 border">{{ $c->tanggal_mulai }}</td>
                            <td class="p-2 border">{{ $c->tanggal_selesai }}</td>
                            <td class="p-2 border">{{ $c->alasan }}</td>
                            <td class="p-2 border">
                                @if($c->status === 'pending')
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($c->status === 'approved')
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">Rejected</span>
                                @endif
                            </td>
                            <td class="p-2 border">
                                @if($c->status === 'pending')
                                    <form action="{{ route('cuti.destroy', $c->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus pengajuan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-gray-500">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
