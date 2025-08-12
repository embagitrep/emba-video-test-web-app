<?php

namespace App\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;

trait IsActive
{
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true)->where('deleted', false);
    }

    public function scopeActiveQuiz(Builder $query): void
    {
        $query->where('active', true)
            ->where('deleted', false)
            ->where('outdated', false);
    }
}
