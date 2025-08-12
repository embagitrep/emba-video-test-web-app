<?php

use App\Models\Message;
use App\Models\Translation;

function getTranslation($name, $params = [], $lang = null)
{

    $slugName = \Illuminate\Support\Str::slug($name);
    $translatedVal = __('translations.'.$slugName);

    if ($translatedVal != 'translations.'.$slugName) {

        foreach ($params as $key => $value) {
            $translatedVal = str_replace("{{$key}}", $value, $translatedVal);
        }

        return $translatedVal;
    }

    $translation = Translation::with('translationOne')->select(['id', 'name'])->where('name', $name)->first();

    if (! isset($lang)) {
        $lang = app()->getLocale();
    }

    if (isset($translation)) {
        $val = $translation->translationOne;
        if (isset($val)) {
            $message = $val->value;
        } else {
            $message = $name;
            $translation = Translation::updateOrCreate([
                'name' => $name,
            ], ['name' => $name]);
            Message::updateOrCreate([
                'translation_id' => $translation->id, 'lang' => $lang, 'value' => $name,
            ], ['translation_id' => $translation->id, 'lang' => $lang, 'value' => $name]);
        }
    } else {
        $message = $name;
        $translation = Translation::updateOrCreate([
            'name' => $name,
        ], ['name' => $name]);
        Message::updateOrCreate([
            'translation_id' => $translation->id, 'lang' => $lang, 'value' => $name,
        ], ['translation_id' => $translation->id, 'lang' => $lang, 'value' => $name]);
    }

    foreach ($params as $key => $value) {
        $message = str_replace("{{$key}}", $value, $message);
    }

    return $message;
}
