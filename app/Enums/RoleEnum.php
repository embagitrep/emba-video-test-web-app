<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum RoleEnum: string
{
    use EnumTrait;

    case ADMIN = 'admin';

    case MANAGER = 'manager';

    case BANK_USER = 'bank_user';

    case MODERATOR = 'moderator';

    case USER = 'user';
}
