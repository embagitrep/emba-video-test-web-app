<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'merchant_id',
        'session_id',
        'phone',
        'message',
        'url',
        'status',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
