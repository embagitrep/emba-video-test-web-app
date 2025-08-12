<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum RelativeTypeEnum: string
{

    use EnumTrait;

    case FAMILY = 'family';

    case FRIEND = 'friend';

    case COLLEAGUE = 'colleague';
}
