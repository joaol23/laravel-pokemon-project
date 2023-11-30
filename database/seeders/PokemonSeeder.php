<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pokemon\Pokemon::factory(10)->create();

        \App\Models\Pokemon\Pokemon::factory()->create([
            'name' => 'Charmander',
            'pokemon_id' => 3,
            'image' => fake()->imageUrl()
        ]);
    }
}
