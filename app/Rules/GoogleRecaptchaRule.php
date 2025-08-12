<?php

namespace App\Rules;

use App\Services\Client\RecaptchaService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GoogleRecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = (new RecaptchaService())->verify($value,request()->ip());
        if (!$response->success){
            $fail('Invalid captcha');
        }
    }
}
