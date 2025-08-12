<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum CurrencyEnum: string
{
    use EnumTrait;

    case AZN = 'azn';

    case USD = 'usd';
}
