<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePhoneRule implements ValidationRule
{

    public array $phones;

    public function __construct(array $phones)
    {
        $this->phones = $phones;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($this->phones) !== count(array_unique($this->phones))) {
            $fail('Phone already used');
        }
    }
}
