@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1100px; margin: 0 auto; padding: 20px;">
    <h2 style="margin-bottom: 20px; text-align:center; color:#2c3e50;">Approval Procurement Requests</h2>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:6px; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    <table style="width:100%; border-collapse:collapse; margin-top:15px; font-size:14px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <thead style="background:#34495e; color:white;">
            <tr>
                <th style="padding:10px; text-align:center;">#</th>
                <th style="padding:10px; text-align:left;">Item</th>
                <th style="padding:10px; text-align:center;">Quantity</th>
                <th style="padding:10px; text-align:left;">Requester</th>
                <th style="padding:10px; text-align:center;">Status</th>
                <th style="padding:10px; text-align:left;">Reason</th>
                <th style="padding:10px; text-align:center;">Photo</th>
                <th style="padding:10px; text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr style="border-bottom:1px solid #ddd; background: {{ $loop->iteration % 2 == 0 ? '#f9f9f9' : 'white' }};">
                    <td style="padding:10px; text-align:center;">{{ $loop->iteration }}</td>
                    <td style="padding:10px;">{{ $req->item_name ?? $req->material->material_name }}</td>
                    <td style="padding:10px; text-align:center;">{{ $req->quantity }}</td>
                    <td style="padding:10px;">{{ $req->requester->name ?? '-' }}</td>
                    <td style="padding:10px; text-align:center;">
                        @if($req->status == 'pending')
                            <span style="background:#f1c40f; color:white; padding:3px 8px; border-radius:4px;">Pending</span>
                        @elseif($req->status == 'approved')
                            <span style="background:#27ae60; color:white; padding:3px 8px; border-radius:4px;">Approved</span>
                        @else
                            <span style="background:#e74c3c; color:white; padding:3px 8px; border-radius:4px;">Rejected</span>
                        @endif
                    </td>
                    <td style="padding:10px;">{{ $req->reason }}</td>
                    <td style="padding:10px; text-align:center;">
                        @if($req->photo)
                            <img src="{{ $req->photoUrl() }}" alt="photo" width="60"
                            style="border-radius:4px; border:1px solid #ddd; cursor:pointer;"
                            onclick="showImageModal('{{ $req->photoUrl() }}')">
                        @else
                              -
                        @endif
                    </td>

                    <td style="padding:10px; text-align:center;">
                        @if($req->status == 'pending')
                            <form action="{{ route('requests.approve', $req->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button style="background:#27ae60; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; margin:2px;">Approve</button>
                            </form>
                            <form action="{{ route('requests.reject', $req->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button style="background:#e74c3c; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; margin:2px;">Reject</button>
                            </form>
                        @else
                            <small style="color:#555;">{{ ucfirst($req->status) }} by {{ $req->approver->name ?? '-' }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:20px; color:#7f8c8d;">No procurement requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $requests->links() }}
    </div>
</div>
<!-- Modal untuk foto -->
<div id="imageModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
            background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
    <span style="position:absolute; top:20px; right:30px; color:white; font-size:30px; 
                 cursor:pointer; font-weight:bold;" onclick="closeImageModal()">×</span>
    <img id="modalImage" src="" 
         style="max-width:90%; max-height:90%; border-radius:8px; box-shadow:0 0 20px rgba(255,255,255,0.3);">
</div>

<script>
    function showImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Supaya bisa tutup modal dengan klik di luar gambar
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target.id === 'imageModal') closeImageModal();
    });
</script>

@endsection
