<?php

namespace App\Exceptions\Upload;

class FileNotUploaded extends \Exception
{
    public function __construct(string $pathFile)
    {
        parent::__construct("Erro ao salvar arquivo {$pathFile}", 500);
    }
}
