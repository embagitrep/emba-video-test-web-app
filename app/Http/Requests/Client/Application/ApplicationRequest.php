<?php

namespace App\Http\Requests\Client\Application;

use App\Enums\RelativeTypeEnum;
use App\Rules\GoogleRecaptchaRule;
use App\Rules\OtpValidation;
use App\Rules\UniquePhoneRule;
use App\Rules\ValidPhoneNumber;
use App\Services\Api\OrderService;
use App\Services\Client\CheckoutService;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $sessionData = (new CheckoutService())->getSessionData(request()->sessionId);

        if (!$sessionData) {
            return [
                'session' => ['required'],
            ];
        }

        $model = (new OrderService())->getBySession($sessionData->session_id);

        $phones = array_column(request()->input('phones', []),'id');
        $phones[] = request()->input('phone');


        return [
            'pin' => ['required', 'alpha_num', 'min:7', 'max:7'],
//            'recaptcha_token' => ['required', new GoogleRecaptchaRule],
            'installment' => ['required','numeric', 'min:3', 'max:'.$model->vendor->max_installment],
            'phone' => ['required', new ValidPhoneNumber, new UniquePhoneRule($phones)],
            'otp' => ['required','numeric', new OtpValidation(request()->input('phone'))],
            'serial' => 'required',
            'phones' => ['required', 'array', 'min:3','max:3'],
            'phones.*.type' => ['required', 'string', 'in:'.implode(',',array_keys(RelativeTypeEnum::toArray()))],
            'phones.*.id' => ['required', 'string', new ValidPhoneNumber, new UniquePhoneRule($phones)],
        ];
    }
}
