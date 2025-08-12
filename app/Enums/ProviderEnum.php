<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum ProviderEnum: string
{
    use EnumTrait;
    case AZIN_TELECOM = 'azin_telecom';
}
