<?php

namespace App\Models;

use App\Traits\CommonScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, CommonScopeTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'website',
        'fb_page',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
