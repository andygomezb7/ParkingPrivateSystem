<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\tipoVehiculo>
 */
class TiposVehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'costo' => $this->faker->randomElement([1, 2]), // Generar un valor aleatorio entre 1 y 2
            'cobro' => $this->faker->randomElement([1, 2]),
        ];
    }
}
