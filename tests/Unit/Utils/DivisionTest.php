<?php

use App\Utils\Math\Division;

test('Divisão tem que arredondar pra cimar', function (
    int $numberA, int $numberB, int $resultExpect
) {
    expect(Division::divisionRoundUp($numberA, $numberB))->toEqual($resultExpect);
})->with([
             [31, 10, 4],
             [30, 10, 3]
         ]);
