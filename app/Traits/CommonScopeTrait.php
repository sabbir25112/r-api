<?php

namespace App\Traits;

trait CommonScopeTrait
{
    public function scopeLimitPaginate($query)
    {
        $limit = request()->has('limit') ? request()->get('limit') : env('DEFAULT_PAGINATION_LIMIT', 20);
        $limit = $limit > 100 ? 100 : $limit;
        return $query->paginate($limit);
    }
}
