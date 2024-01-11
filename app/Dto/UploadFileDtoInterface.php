<?php

namespace App\Dto;
use Illuminate\Http\UploadedFile;

interface UploadFileDtoInterface
{
    public function nameFile(): string;

    public function file(): UploadedFile;
}
