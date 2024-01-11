<?php

namespace App\Contracts\Services;
use App\Dto\UploadFileInterface;

interface UploadFileServiceContract
{
    public function upload(UploadFileInterface $uploadFile): string;
}
