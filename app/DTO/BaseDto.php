<?php

namespace App\DTO;

abstract class BaseDto
{
    public static function fromArray(array $data): static
    {
        $instance = new static(...$data);

        return $instance;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
