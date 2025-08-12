<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Base64DocValidation implements ValidationRule
{
    protected $allowedFileTypes = [
        'jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp',
        'mp4', 'mov', 'avi', 'webm', 'mkv'
    ];

    protected $maxFileSizeInKB = 3500;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            if (! preg_match('/^data:(image|video)\/(\w+);base64,/', $value, $matches)) {
                $fail(getTranslation('Invalid file type'));

                return;
            }

            $base64Data = substr($value, strpos($value, ',') + 1);
            $decodedFileData = base64_decode($base64Data);

            if (! $decodedFileData) {
                $fail(getTranslation('Invalid file data'));

                return;
            }

            $fileType = Str::afterLast(Str::before($value, ';'), '/');
            if (! in_array($fileType, $this->allowedFileTypes)) {
                $fail(getTranslation('Uploaded file must be one of the following file types:').' '.implode(', ',
                    $this->allowedFileTypes).'.');

                return;
            }

            $fileSizeInKB = strlen($decodedFileData) / 1024;
            if ($fileSizeInKB > $this->maxFileSizeInKB) {
                $fail(getTranslation('File size must not exceed').' '.$this->maxFileSizeInKB.' KB.');
            }
        }
    }
}
