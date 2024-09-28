<?php

namespace Database\Factories;

use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;

class TelefonoFactory extends Factory
{
    protected $model = Telefono::class;

    public function definition(): array
    {
        return [
            'numero' => $this->faker->phoneNumber,
        ];
    }
}
