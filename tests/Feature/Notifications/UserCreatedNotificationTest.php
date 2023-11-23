<?php

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Illuminate\Support\Facades\Queue;

beforeEach(fn () => Queue::fake());

test('Notificação foi adicionada na fila', function () {
    $user = User::factory()->createOne();

    $notification = new UserCreatedNotification();
    $user->notify($notification);

    Queue::assertPushed(\Illuminate\Notifications\SendQueuedNotifications::class, 1);
});
