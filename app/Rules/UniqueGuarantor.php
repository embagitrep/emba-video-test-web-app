<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueGuarantor implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = request()->input('guarantors', []);

        $fins = [];
        $phones = [];

        foreach ($data as $guarantor) {
            if (isset($guarantor['fin']) && in_array($guarantor['fin'], $fins)) {
                $fail(getTranslation('FIN already used'));
            }
            if (isset($guarantor['phone']) && in_array($guarantor['phone'], $phones)) {
                $fail(getTranslation('Phone already used'));
            }

            $fins[] = $guarantor['fin'];
            $phones[] = $guarantor['phone'];
        }
    }
}
