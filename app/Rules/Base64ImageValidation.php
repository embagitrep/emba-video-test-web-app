<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Base64ImageValidation implements ValidationRule
{
    protected $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];

    protected $maxSize = 5500;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {

            if (! preg_match('/^data:image\/(\w+);base64,/', $value)) {
                $fail('Uploaded :attribute is invalid image type');
            }

            $base64Data = substr($value, strpos($value, ',') + 1);
            $imageData = base64_decode($base64Data);

            if (! $imageData || ! getimagesizefromstring($imageData)) {
                $fail('Uploaded :attribute is invalid image type');
            }

            $imageType = Str::afterLast(Str::before($value, ';'), '/');
            if (! in_array($imageType, $this->allowedTypes)) {
                $fail(':attribute allowed image types are: '.implode(',', $this->allowedTypes));
            }

            $imageSize = strlen($imageData) / 1024;
            if ($imageSize > $this->maxSize) {
                $fail(':attribute maximum allowed image size is 5MB');
            }
        }

    }
}
