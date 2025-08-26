@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto; padding: 20px; background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom:20px;">Request #{{ $request->id }}</h3>
    <p><b>Type:</b> {{ $request->type_request }}</p>
    <p><b>Item:</b> {{ $request->type_request === 'restock' ? ($request->material?->material_name ?? '-') : $request->item_name }}</p>
    <p><b>Quantity:</b> {{ $request->quantity }}</p>
    <p><b>Reason:</b> {{ $request->reason }}</p>
    <p><b>Status:</b> {{ ucfirst($request->status) }}</p>
    @if($request->photo)
        <p><b>Photo:</b><br><img src="{{ asset('storage/' . $request->photo) }}" style="max-width:100%; border-radius:6px; margin-top:10px;"></p>
    @endif
</div>
@endsection
