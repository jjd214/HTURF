<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'quantity_sold',
        'total_amount',
        'amount_paid',
        'amount_change',
        'commission_amount',
        'status',
        'customer_name'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'code', 'transaction_code');
    }

    // public static function generateUniqueTransactionCode()
    // {
    //     do {
    //         $code = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
    //     } while (Self::where('transaction_code', $code));

    //     return $code;
    // }
}
