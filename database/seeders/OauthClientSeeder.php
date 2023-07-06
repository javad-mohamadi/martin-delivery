<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'user_id'                => null,
            'name'                   => 'Laravel Password Grant Client',
            'secret'                 => 'Yg6swOp3WjmGTyvJuHoXCMxSouBab3G5sQjo5rF6',
            'provider'               => 'users',
            'redirect'               => 'http://localhost',
            'personal_access_client' => false,
            'password_client'        => true,
            'revoked'                => false,
        ]);
    }

}
