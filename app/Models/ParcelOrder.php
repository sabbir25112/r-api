<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParcelOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable= [
        'order_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'city_id',
        'pickup_date',
        'order_request',
        'delivery_shift',
        'status',
    ];

    public  function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}
