<?php

use App\Notifications\UserCreatedNotification;
use Tests\Objects\UserFakeTrait;

uses(UserFakeTrait::class);

test('E-mail enviado com nome do usuário novo', function () {
    $userFake = $this->getFakeModelUser();

    $notification = new UserCreatedNotification();
    $rendered = $notification->toMail($userFake)->render();

    $this->assertStringContainsString(
        "Seja bem vindo à nossa plataforma " . $userFake->getAttribute('name'),
        $rendered
    );
});
