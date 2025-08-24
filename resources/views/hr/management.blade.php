@extends('layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Pengajuan Cuti Karyawan
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

        @if($cutis->isEmpty())
            <p class="text-gray-600">Belum ada pengajuan cuti.</p>
        @else
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Karyawan</th>
                        <th class="p-2 border">Mulai</th>
                        <th class="p-2 border">Selesai</th>
                        <th class="p-2 border">Alasan</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cutis as $c)
                        <tr>
                            <td class="p-2 border">{{ $c->user->name }}</td>
                            <td class="p-2 border">{{ $c->tanggal_mulai }}</td>
                            <td class="p-2 border">{{ $c->tanggal_selesai }}</td>
                            <td class="p-2 border">{{ $c->alasan }}</td>
                            <td class="p-2 border">
                                @if($c->status === 'pending')
                                    <span class="text-yellow-600 font-semibold">Pending</span>
                                @elseif($c->status === 'approved')
                                    <span class="text-green-600 font-semibold">Approved</span>
                                @else
                                    <span class="text-red-600 font-semibold">Rejected</span>
                                @endif
                            </td>
                            <td class="p-2 border">
    @if($c->status === 'pending')
        <form action="{{ route('hr.cuti.approve', $c->id) }}" method="POST" class="inline">
            @csrf
<button style="padding:6px 12px;background-color:#16a34a;color:#fff;border-radius:4px;">
    Approve
</button>        </form>
        <form action="{{ route('hr.cuti.reject', $c->id) }}" method="POST" class="inline">
            @csrf
            <button class="px-2 py-1 bg-red-600 text-white rounded">Reject</button>
        </form>
    @else
        <span class="text-gray-500">Sudah {{ $c->status }}</span>
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
