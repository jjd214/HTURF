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
        'total_price',
        'reason_for_refund',
        'customer_name',
        'status'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = '%' . $value . '%';

        return $query->where(function ($query) use ($value) {
            $query->where('transaction_code', 'like', $value)
                ->orWhere('customer_name', 'like', $value);
        });
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }

        return $query;
    }
}
