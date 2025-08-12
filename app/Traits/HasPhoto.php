<?php

namespace App\Traits;

use App\Models\Gallery;

trait HasPhoto
{
    public function gallery()
    {
        return $this->morphMany(Gallery::class, 'model')->orderBy('sort');
    }

    public function getPhotoItem($i = null)
    {
        $photo = null;
        if ($this->gallery) {
            $sorted = $this->gallery;
            if (count($sorted)) {
                if (! $i) {
                    $item = $sorted->first();
                    $photo = $item->file_name;
                } else {
                    $item = $sorted->get($i);
                    if ($item) {
                        $photo = $item->file_name;
                    }
                }
            }
        }

        return $photo;
    }

    public function getPhotoByType(string $type)
    {
        $photo = null;
        if ($this->gallery) {
            $item = $this->gallery->where('file_type', $type)->first();
            if ($item) {
                $photo = $item->file_name;
            }
        }

        return $photo;
    }
}
