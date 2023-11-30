<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PokemonTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            \App\Models\Pokemon\PokemonTypes::factory(10)->create();

            \App\Models\Pokemon\PokemonTypes::factory()->create([
                'name' => 'Normal',
                'color' => 'white'
            ]);
        }
    }
}
