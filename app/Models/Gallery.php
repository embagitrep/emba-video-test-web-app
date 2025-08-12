<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = ['model_id', 'model_type', 'file_name', 'mime_type', 'file_type', 'sort'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($item) {
            $item->removeFile();
        });
    }

    public function fileName(): Attribute
    {
        //        $path = (new CDNService())->getCdnUrl();
        $path = '';

        return Attribute::make(
            get: static fn ($value) => $path.$value,
        );
    }

    protected function removeFile(): void
    {
        $filePath = storage_path('app/'.$this->file_name);

        if (! file_exists($filePath)) {
            return;
        }

        unlink($filePath);
    }

    public function photoable()
    {
        return $this->morphTo('model');
    }
}
