<?php

namespace App\Services\Upload\Adapters;

use App\Dto\UploadFileDtoInterface;
use Illuminate\Support\Facades\Storage;

class FileUploadAdapter implements UploadAdapterInterface
{
    public function save(
        string $path,
        UploadFileDtoInterface $fileDto
    ): string {
        if (!$this->createDir($path)) {
            exit(); // TODO
        }
        $pathFile = $path . DIRECTORY_SEPARATOR . $fileDto->nameFile();
        if (
            !Storage::disk('public')
                ->put($pathFile, $fileDto->file()->getContent())
        ) {
            exit();
        }
        return Storage::disk('public')
            ->url($pathFile);
    }

    private function createDir(
        string $path
    ): bool {
        return Storage::disk('public')
            ->makeDirectory($path);
    }

    public function exists(
        $path
    ): bool {
        // TODO: Implement exists() method.
    }

    public function delete(
        $path
    ): bool {
        // TODO: Implement delete() method.
    }
}
