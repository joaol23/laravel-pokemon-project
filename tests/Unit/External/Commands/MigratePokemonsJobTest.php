<?php


use App\Jobs\MigratePokemonsJob;
use Illuminate\Support\Facades\Queue;

beforeEach(fn() => Queue::fake());

test('Testando se o número de dispatchs na fila está corretos', function () {
    $this->artisan('migrate-pokemons')->assertExitCode(1);

    Queue::assertPushedOn('pokemon_migration', MigratePokemonsJob::class);
    Queue::assertPushed(MigratePokemonsJob::class, 4);
});
