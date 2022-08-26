<?php

namespace App\Models;

use App\Traits\CommonScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, CommonScopeTrait;

    protected $fillable = [
        'service_id',
        'pickup_date',
        'merchant_id',
        'payment_type',
        'status',
    ];


    public  function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public  function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function parcelOrders()
    {
        return $this->hasMany(ParcelOrder::class);
    }

}
