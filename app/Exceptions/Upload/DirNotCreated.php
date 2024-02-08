<?php

namespace App\Exceptions\Upload;

class DirNotCreated extends \Exception
{
    public function __construct()
    {
        parent::__construct("Erro ao tentar criar pasta para upload", 500);
    }
}
