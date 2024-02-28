<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PokemonExternalServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use App\Http\Resources\Default\ApiResponseResource;
use App\Http\Resources\PokemonCollectionResource;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function __construct(
        private readonly PokemonServiceContract $pokemonService,
        private readonly PokemonExternalServiceContract $pokemonExternalService
    ) {
    }

    public function index(
        Request $request
    ): PokemonCollectionResource {
        $searchParam = $request->query('q');
        if ($searchParam) {
            return new PokemonCollectionResource(
                $this->pokemonService
                    ->search($searchParam)
            );
        }
        return new PokemonCollectionResource(
            $this->pokemonService
                ->listAll()
        );
    }

    public function details(string $name): ApiResponseResource
    {
        return new ApiResponseResource(
            $this->pokemonExternalService->getPokemon($name)
        );
    }
}
