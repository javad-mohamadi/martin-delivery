<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OauthClientSeeder::class);
        $this->call(RoleSeeder::class);

        $shopCompany = User::factory()->create(['email' => 'shop.company@test.com']);
        $foodCompany = User::factory()->create(['email' => 'food.company@test.com']);
        $pedram      = User::factory()->create(['email' => 'pedram.courier@test.com']);
        $peyman      = User::factory()->create(['email' => 'peyman.courier@test.com']);

        $shopCompany->assignRole('company');
        $foodCompany->assignRole('company');
        $pedram->assignRole('courier');
        $peyman->assignRole('courier');
    }
}
