<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'Ekodrive';
        $slug = Str::slug($name);

        $apiUsername = 'ekodrive';
        $apiKey = 'WTeKhuMaZgp4kmoKwSULucaGN6aMmhge';

        $merchant = Merchant::where('api_username', $apiUsername)
            ->orWhere('slug', $slug)
            ->first();

        if ($merchant) {
            $merchant->update([
                'name' => $name,
                'slug' => $slug,
                'api_username' => $apiUsername,
                'api_key' => $apiKey,
            ]);
        } else {
            Merchant::create([
                'name' => $name,
                'slug' => $slug,
                'api_username' => $apiUsername,
                'api_key' => $apiKey,
            ]);
        }
    }
}




