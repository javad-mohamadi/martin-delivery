<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class CompanyFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name'        => fake()->name(),
            'webhook_url' => fake()->unique()->url() . 'webhook',
        ];
    }

}
