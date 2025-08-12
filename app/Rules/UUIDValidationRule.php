<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Ramsey\Uuid\Uuid;

class UUIDValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            if (! Uuid::isValid($value)) {
                $fail($attribute.' '.$value.' is invalid');
            }
        } else {
            foreach ($value as $uuid) {
                if (! Uuid::isValid($uuid)) {
                    $fail($attribute.' '.$value.' is invalid');
                }
            }
        }
    }
}
