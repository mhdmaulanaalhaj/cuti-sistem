@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 900px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 20px;">Procurement Requests</h3>
    <a href="{{ route('requests.create') }}" style="display:inline-block; padding:8px 14px; background:#4CAF50; color:white; text-decoration:none; border-radius:6px; margin-bottom:10px;">+ New Request</a>
    
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width:100%; border-collapse: collapse; margin-top:10px;">
        <thead>
            <tr style="background:#f8f9fa; text-align:left;">
                <th style="padding:10px; border:1px solid #ddd;">#</th>
                <th style="padding:10px; border:1px solid #ddd;">Type</th>
                <th style="padding:10px; border:1px solid #ddd;">Item / Material</th>
                <th style="padding:10px; border:1px solid #ddd;">Qty</th>
                <th style="padding:10px; border:1px solid #ddd;">Status</th>
                <th style="padding:10px; border:1px solid #ddd;">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($requests as $r)
            <tr>
                <td style="padding:10px; border:1px solid #ddd;">{{ $r->id }}</td>
                <td style="padding:10px; border:1px solid #ddd;">{{ $r->type_request }}</td>
                <td style="padding:10px; border:1px solid #ddd;">
                    {{ $r->type_request == 'restock' ? ($r->material?->material_name ?? '-') : $r->item_name }}
                </td>
                <td style="padding:10px; border:1px solid #ddd;">{{ $r->quantity }}</td>
                <td style="padding:10px; border:1px solid #ddd;">{{ ucfirst($r->status) }}</td>
                <td style="padding:10px; border:1px solid #ddd;">
                    <a href="{{ route('requests.show', $r) }}" style="padding:4px 8px; background:#17a2b8; color:white; text-decoration:none; border-radius:4px;">View</a>
                    @if(auth()->id() === $r->requested_by && $r->status === 'pending')
                        <a href="{{ route('requests.edit', $r) }}" style="padding:4px 8px; background:#ffc107; color:white; text-decoration:none; border-radius:4px;">Edit</a>
                        <form action="{{ route('requests.destroy', $r) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button style="padding:4px 8px; background:#dc3545; color:white; border:none; border-radius:4px; cursor:pointer;" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    @endif

                    @if(auth()->user()->role === 'manager' && $r->status === 'pending')
                        <form action="{{ route('requests.approve', $r) }}" method="POST" style="display:inline">
                            @csrf
                            <button style="padding:4px 8px; background:#28a745; color:white; border:none; border-radius:4px; cursor:pointer;">Approve</button>
                        </form>
                        <form action="{{ route('requests.reject', $r) }}" method="POST" style="display:inline">
                            @csrf
                            <button style="padding:4px 8px; background:#6c757d; color:white; border:none; border-radius:4px; cursor:pointer;">Reject</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:10px;">
        {{ $requests->links() }}
    </div>
</div>
@endsection
