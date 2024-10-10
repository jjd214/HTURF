<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignor_id',
        'commission_percentage',
        'consignment_price',
        'start_date',
        'expiry_date'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($con) {
    //         $consignment->inventory()->delete();
    //     });
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($inventory) {
    //         if ($inventory->consignment) {
    //             $inventory->consignment->delete();
    //         }
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'consignor_id');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'consignment_id');
    }
}
