@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-sm rounded-lg p-6 mt-6">
    <h2 class="text-lg font-semibold mb-4">Form Pengajuan Cuti</h2>

    @if($errors->any())
        <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cuti.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                   class="mt-1 w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                   class="mt-1 w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Alasan</label>
            <textarea name="alasan" required class="mt-1 w-full border rounded p-2">{{ old('alasan') }}</textarea>
        </div>
        <button style="background-color:#16a34a; color:white; padding:8px 16px; border-radius:8px;">
    Ajukan
</button>

    </form>
</div>
@endsection
