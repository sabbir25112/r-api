<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CommonScopeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, CommonScopeTrait, SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
