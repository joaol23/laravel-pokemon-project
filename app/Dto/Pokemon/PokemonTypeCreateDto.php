<?php

namespace App\Dto\Pokemon;

use App\Dto\BaseDto;
use App\Models\Pokemon\PokemonTypes;

class PokemonTypeCreateDto extends BaseDto
{
    public string $color;

    public function __construct(
        public string $name,
    ) {
        $this->name = strtolower($this->name);
        $this->setColor();
    }

    private function setColor(): void
    {
        $this->color = PokemonTypes::$colorsTypes[$this->name] ?? 'white';
    }

}
