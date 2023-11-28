<?php

namespace App\Console\Commands;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
use App\Jobs\MigratePokemonsJob;
use App\Utils\Math\Division;
use Illuminate\Console\Command;

class PokemonsMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-pokemons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate all pokemons jobs to import pokemons
    from external api to database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $quantityJobs = Division::divisionRoundUp(PokeApi::pokemons()->limit(1)->get()->count, 10);
        for ($i = 1; $i <= $quantityJobs; $i++) {
            MigratePokemonsJob::dispatch($i, 10);
        }
    }
}
