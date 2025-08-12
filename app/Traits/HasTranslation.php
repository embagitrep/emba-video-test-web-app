<?php

namespace App\Traits;

trait HasTranslation
{
    protected function getClass(): string
    {
        return static::class;
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslateClass(), $this->translationParentId);
    }

    public function translation()
    {
        return $this->hasOne($this->getTranslateClass(), $this->translationParentId)->where('lang', '=', locale());
    }

    protected function getTranslateClass(): string
    {
        $trClass = $this->getClass().'Translate';

        if (! class_exists($trClass)) {
            $trClass = $this->getClass().'Translation';
        }
        if (! class_exists($trClass)) {
            throw new \Exception('Translatable class not found for '.$this->getClass());
        }

        return $trClass;
    }

    public function getTranslation($key, $locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }

        if (is_array($this->translatedAttributes) && ! in_array($key, $this->translatedAttributes)) {
            return '';
        }

        $this->load('translations');

        $translation = $this->getTranslateClass()::where("$this->translationParentId", $this->id)->where('lang', $locale)->first();

        if (! $translation) {
            return '';
        } else {
            return $translation->$key;
        }
    }

    public function getTranslationOne($key)
    {

        if (is_array($this->translatedAttributes) && ! in_array($key, $this->translatedAttributes)) {
            return '';
        }

        $translation = $this->translation;
        if (! $translation) {
            if ($key == 'name') {
                return $this->{$key};
            }

            return '';
        } else {
            $tr = $translation->{$key};
            if (! isset($tr)) {
                return $this->{$key};
            }

            return $tr;
        }
    }
}
