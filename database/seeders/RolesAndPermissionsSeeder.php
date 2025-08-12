<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
        'company-list',
        'company-create',
        'company-edit',
        'company-delete',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'manager'])->givePermissionTo(['company-edit', 'user-edit']);
        Role::create(['name' => 'moderator']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'driver']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $user = User::create([
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole('admin');

    }
}
