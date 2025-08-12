<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxSentences implements ValidationRule
{
    protected $maxSentences;

    public function __construct($maxSentences)
    {
        $this->maxSentences = $maxSentences;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sentences = preg_split('/[.!?]+/', $value, -1, PREG_SPLIT_NO_EMPTY);

        if (count($sentences) >= $this->maxSentences) {
            $fail('Maximum number of sentences reached');
        }

    }
}
