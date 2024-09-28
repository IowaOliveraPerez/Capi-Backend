<?php

namespace Database\Factories;

use App\Models\Contacto;
use App\Models\Direccion;
use App\Models\Email;
use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    protected $model = Contacto::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'notas' => $this->faker->sentence,
            'fecha_cumpleaños' => $this->faker->date(),
            'pagina_web' => $this->faker->url,
            'empresa' => $this->faker->company
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Contacto $contacto) {
            $contacto->telefonos()->saveMany(Telefono::factory()->count(rand(1, 3))->make());
            $contacto->direcciones()->saveMany(Direccion::factory()->count(rand(1, 3))->make());
            $contacto->emails()->saveMany(Email::factory()->count(rand(1, 3))->make());
        });
    }
}
