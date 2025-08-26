<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementRequest extends Model
{
    protected $fillable = [
        'type_request',
        'material_id',
        'item_name',
        'quantity',
        'reason',
        'photo',
        'status',
        'requested_by',
        'approved_by',
    ];

    public function material()
    {
        return $this->belongsTo(Inventory::class, 'material_id');
    }

    public function requester()
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    // helper to return public url for photo
    public function photoUrl()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
