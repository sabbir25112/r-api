<?php

namespace App\Models;
use App\Traits\CommonScopeTrait;
use \Spatie\Permission\Models\Permission as SpatiePermisson;

class Permission extends SpatiePermisson
{
    use CommonScopeTrait;

    protected $appends = [
        'display_name',
    ];

    public function getDisplayNameAttribute()
    {
        return ucwords(str_replace('.', ' ', $this->name));
    }
}
