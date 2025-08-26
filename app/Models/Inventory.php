<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'price',
        'currency_id',
        'supplier_id',
        'location_id',
        'remark',
        'img',
        'qrcode_path',
        'qrcode',
        'category_id',
    ];
}
