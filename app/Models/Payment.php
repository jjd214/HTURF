<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'payment_code',
        'quantity',
        'tax',
        'total',
        'status',
        'date_of_payment'
    ];
}
