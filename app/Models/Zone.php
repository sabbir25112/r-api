<?php

namespace App\Models;

use App\Traits\CommonScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory, CommonScopeTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'city_id',
    ];

    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
