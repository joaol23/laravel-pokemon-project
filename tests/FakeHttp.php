<?php

namespace Tests;

use Illuminate\Support\Facades\Http;

trait FakeHttp
{
    public function fake(): void
    {
        $pokemonsData = file_get_contents(base_path('tests/Fixtures/pokemons.json'));
        Http::fake([
            "https://pokeapi.co/api/v2/pokemon*" => Http::response(
                $pokemonsData
            )
        ]);
    }
}
