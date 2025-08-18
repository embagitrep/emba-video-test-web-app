<?php

namespace App\Models;

use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids, HasPhoto;

    protected $fillable = [
        'merchant_id',
        'session_id',
        'app_id',
        'phone',
        'city',
        'address',
        'salary',
        'name',
        'amount',
        'status',
        'api_version',
        'redirect_url',
        'webhook_url',
        'description',
        'lang',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
