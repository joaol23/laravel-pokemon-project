<?php

namespace App\Dto;
use Illuminate\Http\UploadedFile;

interface UploadFileInterface
{
    public function nameFile(): string;

    public function file(): UploadedFile;
}
