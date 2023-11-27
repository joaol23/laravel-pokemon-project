<?php

namespace App\Console\Commands;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
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
    public function handle()
    {
        dd(PokeApi::pokemons()->limit(10)->page(1)->get());
    }
}
