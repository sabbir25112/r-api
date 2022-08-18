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
}
