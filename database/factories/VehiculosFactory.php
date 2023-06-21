<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculos>
 */
class VehiculosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placa' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'type' => $this->faker->randomElement([1, 2]), // Generar un valor aleatorio entre 1 y 2
            'marca' => $this->faker->company,
            'modelo_linea' => $this->faker->word,
        ];
    }
}
