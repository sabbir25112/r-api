<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parcel_order_id',
        'name',
        'quantity',
        'cod_amount',
        'status',
    ];

    public function parcelOrder()
    {
        return $this->belongsTo(ParcelOrder::class, 'parcel_order_id');
    }
}
