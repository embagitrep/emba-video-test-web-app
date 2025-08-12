<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumber implements ValidationRule
{
    protected array $operators = ['050', '051', '055', '070', '077', '040', '010', '099'];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^\(\d{3}\) \d{3}-\d{2}-\d{2}$/', $value)) {
            $fail(getTranslation('Invalid phone type'));
        }

        $operator = substr($value, 1, 3);

        if (! in_array($operator, $this->operators)) {
            $fail(getTranslation('Invalid phone operator'));
        }

    }
}
