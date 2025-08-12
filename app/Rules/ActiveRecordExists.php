<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ActiveRecordExists implements ValidationRule
{
    protected $table;

    protected $column;

    protected $activeColumn;

    public function __construct($table, $column = 'id', $activeColumn = 'active')
    {
        $this->table = $table;
        $this->column = $column;
        $this->activeColumn = $activeColumn;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table($this->table)
            ->where($this->column, $value)
            ->where($this->activeColumn, true)
            ->where('deleted', 0)
            ->exists();

        if (! $exists) {
            $fail("{$this->table} doesn't exist");
        }
    }
}
