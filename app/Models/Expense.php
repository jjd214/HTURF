<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id', 'purchase_price', 'qty'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
