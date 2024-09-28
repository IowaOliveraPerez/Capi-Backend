<?php

namespace Database\Factories;

use App\Models\Direccion;
use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Telefono>
 */
class DireccionFactory extends Factory
{
    protected $model = Direccion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'direccion' => $this->faker->address,
        ];
    }
}
