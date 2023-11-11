<?php

use App\Utils\Params\ValidId;
use Illuminate\Validation\ValidationException;
use \Illuminate\Support\Str;

test("Deve retornar id com tipo int", function () {
    $id = "3";

    $validId = ValidId::validate($id);

    expect($validId)->toBe(3);
    expect($validId)->toBeInt();
});

test("Não pode aceitar id inválido", function ($id) {
    ValidId::validate($id);
})->with(
    [
        "string aleatoria" => Str::random(),
        "string com numero" => "22f",
        "objeto vazio" => new stdClass()
    ]
)->throws(ValidationException::class, "O campo id deve ser um número.");
