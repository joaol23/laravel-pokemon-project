<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()
            ->create([
                         'email'    => 'teste@example.com',
                         'password' => Hash::make('password'),
                     ]);
        $this->call([
                        PokemonSeeder::class,
                        PokemonTypesSeeder::class
                    ]);
    }
}
