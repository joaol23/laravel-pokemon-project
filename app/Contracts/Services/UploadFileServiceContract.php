<?php

namespace App\Contracts\Services;

use App\Dto\UploadFileDtoInterface;

interface UploadFileServiceContract
{
    public function upload(
        UploadFileDtoInterface $uploadFile,
        string $path
    ): string;
}
