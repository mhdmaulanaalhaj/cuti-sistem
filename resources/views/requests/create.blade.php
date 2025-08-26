@extends('layouts.app')
@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto; padding: 20px; background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom:20px;">Create Request</h3>
    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:12px;">
            <label>Type Request</label>
            <select id="type_request" name="type_request" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                <option value="new_request">New Request</option>
                <option value="restock">Restock</option>
            </select>
        </div>

        <div id="new_fields">
            <div style="margin-bottom:12px;">
                <label>Item Name</label>
                <input type="text" name="item_name" value="{{ old('item_name') }}" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
            </div>
            <div style="margin-bottom:12px;">
                <label>Photo (required for new request)</label>
                <input type="file" name="photo" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
            </div>
        </div>

        <div id="restock_fields" style="display:none;">
            <div style="margin-bottom:12px;">
                <label>Material</label>
                <select name="material_id" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                    <option value="">-- select material --</option>
                    @foreach($materials as $m)
                        <option value="{{ $m->id }}">{{ $m->material_name }} (stock: {{ $m->stock }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom:12px;">
            <label>Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity',1) }}" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:12px;">
            <label>Reason</label>
            <textarea name="reason" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">{{ old('reason') }}</textarea>
        </div>

        <button style="padding:8px 14px; background:#4CAF50; color:white; border:none; border-radius:6px; cursor:pointer;">Submit</button>
    </form>
</div>

<script>
    const typeSel = document.getElementById('type_request');
    const newF = document.getElementById('new_fields');
    const restF = document.getElementById('restock_fields');

    function toggle() {
        if (typeSel.value === 'new_request') {
            newF.style.display = '';
            restF.style.display = 'none';
        } else {
            newF.style.display = 'none';
            restF.style.display = '';
        }
    }
    typeSel.addEventListener('change', toggle);
    window.addEventListener('load', toggle);
</script>
@endsection
