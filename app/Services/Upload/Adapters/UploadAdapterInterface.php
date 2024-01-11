<?php

namespace App\Services\Upload\Adapters;

use App\Dto\UploadFileDtoInterface;

interface UploadAdapterInterface
{
    public function save(
        string $path,
        UploadFileDtoInterface $fileDto
    ): string;

    public function exists(
        $path
    ): bool;

    public function delete(
        $path
    ): bool;
}
