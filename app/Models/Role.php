<?php

namespace App\Models;
use App\Traits\CommonScopeTrait;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use CommonScopeTrait;
}
