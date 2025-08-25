<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@admin.com';
        $username = 'admin';

        $user = User::query()->where('email', $email)->orWhere('username', $username)->first();

        if (! $user) {
            $user = new User();
            // UUID handled by HasUuids
        }

        $user->name = 'Admin';
        $user->username = $username;
        $user->email = $email;
        $user->password = 'admin'; // hashed via model cast
        $user->active = true;
        $user->restricted = false;
        $user->deleted = false;
        $user->save();

        // Assign role if Spatie roles are present
        if (method_exists($user, 'assignRole')) {
            try {
                $user->assignRole('admin');
            } catch (\Throwable $e) {
                // Role may not exist yet; ignore silently
            }
        }
    }
}


