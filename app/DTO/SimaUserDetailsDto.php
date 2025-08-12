<?php

namespace App\DTO;

class SimaUserDetailsDto extends BaseDto
{
    public string $name;

    public string $surname;

    public string $serial;

    public function __construct($name, $surname, $serial)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->serial = $serial;
    }
}
