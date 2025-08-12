<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CheckVendorMerchant implements ValidationRule
{

    protected string $merchantId;

    public function __construct(string $merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!DB::table('vendor_merchants')->where('merchant_id', $this->merchantId)->where('vendor_id', $value)->exists()) {
            $fail('Invalid vendor');
        }
    }
}
