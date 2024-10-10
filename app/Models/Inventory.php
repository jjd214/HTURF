<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'name',
        'brand',
        'sku',
        'size',
        'color',
        'sex',
        'qty',
        'description',
        'purchase_price',
        'selling_price',
        'picture',
        'visibility'
    ];

    public function consignment()
    {
        return $this->belongsTo(Consignment::class, 'consignment_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($inventory) {
            if ($inventory->consignment) {
                $inventory->consignment->delete();
            }
        });
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('brand', 'like', "%{$value}%")
            ->orWhere('sku', 'like', "%{$value}%");
    }
}
