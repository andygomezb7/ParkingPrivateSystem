<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vehiculos;
use App\Models\TiposVehiculo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Vehiculos::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Andy',
            'email' => 'parking@bluemedical.com',
            'password' => Hash::make('123456'),
        ]);

        \App\Models\Vehiculos::factory()->create([
            'type' => 1,
            'placa' => 'P0543WEF',
            'marca' => 'Toyota',
            'modelo_linea' => 'Yaris 2006',
        ]);

        \App\Models\Vehiculos::factory()->create([
            'type' => 2,
            'placa' => 'P0550SRF',
            'marca' => 'Kia',
            'modelo_linea' => 'Rio 2020',
        ]);

        \App\Models\TiposVehiculo::factory()->create([
            'name' => 'Residente',
            'costo' => '0.05',
            'cobro' => 1,
        ]);

        \App\Models\TiposVehiculo::factory()->create([
            'name' => 'Oficial',
            'costo' => '0.0',
            'cobro' => 0,
        ]);
    }
}
