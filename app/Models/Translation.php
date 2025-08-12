<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use Cachable, HasFactory, HasUuids;

    protected $fillable = ['name'];

    protected $translatedAttributes = ['value'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function translation($lang)
    {
        return $this->hasOne('App\Models\Message')->where('lang', '=', $lang);
    }

    public function translationOne()
    {
        return $this->hasOne(Message::class)->where('lang', locale());
    }
}
