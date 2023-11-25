<?php

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Illuminate\Support\Facades\Queue;
use Tests\Objects\UserFakeTrait;
use function Pest\Laravel\post;

beforeEach(fn() => Queue::fake());

describe("Testando se notificação é adicionada em fila", function () {
    test('sucesso', function () {
        $user = User::factory()->createOne();


        $notification = new UserCreatedNotification();
        $user->notify($notification);

        Queue::assertPushed(\Illuminate\Notifications\SendQueuedNotifications::class, 1);
    });
});

describe("Testando se fluxo de usuário criado coloca notificação em fila", function () {
    uses(UserFakeTrait::class);

    test('sucesso', closure: function () {
        $newUser = $this->getFakeUser();

        post(route("register"), $newUser)
            ->assertStatus(201)->json("data");

        Queue::assertPushed(\Illuminate\Notifications\SendQueuedNotifications::class, 1);
    });
});
