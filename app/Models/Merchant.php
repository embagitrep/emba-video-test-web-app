<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'logo',
        'slug',
        'api_key',
        'api_username',
    ];

    public function getLogo()
    {
        return '/uploads/'.$this->logo;
    }
}
