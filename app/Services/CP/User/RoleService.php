<?php

namespace App\Services\CP\User;

use App\Enums\RoleEnum;
use App\Models\Role;

class RoleService
{
    public function getRoles()
    {
        return Role::all();
    }

    public function getRoleEnums()
    {
        return RoleEnum::toArray();
    }
}
