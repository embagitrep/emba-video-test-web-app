<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum VideoStatusEnum: string
{
    use EnumTrait;

    case PENDING = 'pending';

    case RECORDED = 'recorded';

    case SENT = 'sent';

    case OK = 'ok';
}
