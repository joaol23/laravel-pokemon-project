<?php

namespace App\Dto;

abstract class BaseDto implements BaseDtoInterface
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
