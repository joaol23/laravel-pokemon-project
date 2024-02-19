<?php

namespace App\Exceptions;

class ErroSavingImageUser extends \Exception
{
    public function __construct()
    {
        parent::__construct("Erro ao salvar imagem de cliente no banco!");
    }
}
