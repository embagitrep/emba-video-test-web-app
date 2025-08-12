<?php

namespace App\Traits\Scope\Loan;

use Illuminate\Database\Eloquent\Builder;

trait Submitted
{
    public function scopeSubmitted(Builder $query): void
    {
        $query->where('submitted', true);
    }

    public function scopeNotSubmitted(Builder $query): void
    {
        $query->where('submitted', false);
    }
}
