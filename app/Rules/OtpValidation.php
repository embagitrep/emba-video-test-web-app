<?php

namespace App\Rules;

use App\Services\Client\OtpService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OtpValidation implements ValidationRule
{

    protected string $phone;

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phone = normalizePhoneNumber($this->phone);
        $result = (new OtpService())->check($phone, $value);

        if (!$result->status){
            $fail(getTranslation('Invalid OTP'));
        }

    }
}
