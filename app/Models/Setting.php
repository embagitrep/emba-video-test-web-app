<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasUuids; // , Cachable;

    protected $fillable = ['name', 'value'];

    public static function getSetting($name)
    {
        return Setting::where('name', $name)->first();
    }
}
