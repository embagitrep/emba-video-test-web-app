<?php

namespace App\Traits;

trait ModelDefaultsTrait
{
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', 0);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
