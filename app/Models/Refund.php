<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'inventory_id',
        'size',
        'quantity',
        'reason_for_refund',
        'customer_name',
        'status'
    ];
}
