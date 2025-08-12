<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPrice
{
    protected function price(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => $value / 100,
            set: static fn ($value) => $value * 100
        );
    }
}
