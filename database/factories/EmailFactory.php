<?php

namespace Database\Factories;

use App\Models\Direccion;
use App\Models\Email;
use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Telefono>
 */
class EmailFactory extends Factory
{
    protected $model = Email::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
        ];
    }
}
