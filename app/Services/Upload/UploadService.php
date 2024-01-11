<?php

namespace App\Services\Upload;

use App\Contracts\Services\UploadFileServiceContract;
use App\Dto\UploadFileDtoInterface;
use App\Services\Upload\Adapters\UploadAdapterInterface;

class UploadService implements UploadFileServiceContract
{
    public function __construct(
        private readonly UploadAdapterInterface $adapter
    ) {
    }

    public function upload(
        UploadFileDtoInterface $uploadFile,
        string $path
    ): string {
        return $this->adapter
            ->save($path, $uploadFile);
    }

    private function generatePath(
        UploadFileDtoInterface $uploadFileDto
    ): string {
        return $uploadFileDto->file()
                ->getClientOriginalName()
            . '_' . time() . '.'
            . $uploadFileDto->file()
                ->getClientOriginalExtension();
    }
}
