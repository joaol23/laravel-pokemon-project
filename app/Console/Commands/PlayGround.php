<?php

namespace App\Console\Commands;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
use App\Repositories\Pokemon\PokemonRepository;
use App\Repositories\Pokemon\PokemonTypesRepository;
use App\Services\Pokemon\PokemonMigrateService;
use App\Services\Pokemon\PokemonService;
use App\Services\Pokemon\PokemonTypesService;
use Illuminate\Console\Command;

class PlayGround extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $teste = new PokemonMigrateService(
            new PokeApi()
            , new PokemonService(
            new PokemonRepository(), new PokemonTypesService(new PokemonTypesRepository())
        )
        );
        $teste->migrate(1, 1);
    }
}
