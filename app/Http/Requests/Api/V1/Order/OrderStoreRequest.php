<?php

namespace App\Http\Requests\Api\V1\Order;

use App\Enums\CurrencyEnum;
use App\Rules\CheckVendorMerchant;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_id' => 'required|max:255',
            'phone' => 'required|string|min:9|max:9',
            'amount' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'currency' => 'nullable|string|in:'.implode(',', array_keys(CurrencyEnum::toArray())),
            'lang' => 'nullable|string|in:'.implode(',', array_keys(locales())),
            'redirect_url' => 'nullable|string|url',
            'webhook_url' => 'required|string|url',
            'name' => 'nullable|string|required_without:description',
            'description' => 'nullable|string|max:255',
        ];
    }
}
