<?php

namespace Database\Seeders;

use App\Models\Company;
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

        $superAdmin       = User::factory()->create(['email' => 'superadmin@test.com']);
        $admin            = User::factory()->create(['email' => 'admin@test.com']);
        $shopCompanyOwner = User::factory()->create(['email' => 'shop.company@test.com']);
        $foodCompanyOwner = User::factory()->create(['email' => 'food.company@test.com']);
        $pedram           = User::factory()->create(['email' => 'pedram.courier@test.com']);
        $peyman           = User::factory()->create(['email' => 'peyman.courier@test.com']);

        $superAdmin->assignRole('super_admin');
        $admin->assignRole('admin');
        $shopCompanyOwner->assignRole('company');
        $foodCompanyOwner->assignRole('company');
        $pedram->assignRole('courier');
        $peyman->assignRole('courier');

        Company::factory()->create(['user_id' => $shopCompanyOwner->id,]);
        Company::factory()->create(['user_id' => $shopCompanyOwner->id,]);

        Company::factory()->create(['user_id' => $foodCompanyOwner->id,]);
        Company::factory()->create(['user_id' => $foodCompanyOwner->id,]);
    }
}
