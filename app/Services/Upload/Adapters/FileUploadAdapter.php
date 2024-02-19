<?php

namespace App\Services\Upload\Adapters;

use App\Dto\UploadFileDtoInterface;
use App\Exceptions\Upload\DirNotCreated;
use App\Exceptions\Upload\FileNotUploaded;
use Illuminate\Support\Facades\Storage;

class FileUploadAdapter implements UploadAdapterInterface
{
    private const DISK_PUBLIC = "public";

    public function save(
        string $path,
        UploadFileDtoInterface $fileDto
    ): string {
        if (!$this->createDir($path)) {
            throw new DirNotCreated();
        }
        $pathFile = $path . DIRECTORY_SEPARATOR . $fileDto->nameFile();
        if (
            !Storage::disk(self::DISK_PUBLIC)
                    ->put($pathFile, $fileDto->file()
                        ->getContent())
        ) {
            throw new FileNotUploaded($pathFile);
        }
        return Storage::disk(self::DISK_PUBLIC)
            ->url($pathFile);
    }

    private function createDir(
        string $path
    ): bool {
        return Storage::disk(self::DISK_PUBLIC)
            ->makeDirectory($path);
    }

    public function exists(
        $path
    ): bool {
        return Storage::disk(self::DISK_PUBLIC)
            ->exists($path);
    }

    public function delete(
        $path
    ): bool {
        return Storage::disk(self::DISK_PUBLIC)
            ->delete($path);
    }
}
