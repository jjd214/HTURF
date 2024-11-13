<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignor_id',
        'name',
        'brand',
        'sku',
        'colorway',
        'size',
        'description',
        'sex',
        'quantity',
        'condition',
        'status',
        'purchase_price',
        'selling_price',
        'consignor_commission',
        'pullout_date',
        'image',
        'note'
    ];
}
