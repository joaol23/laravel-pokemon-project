<?php

namespace App\Dto\User;
use App\Dto\BaseDto;
use App\Dto\UploadFileInterface;
use Illuminate\Http\UploadedFile;

class UserProfileSaveImageInterface extends BaseDto implements UploadFileInterface
{
    public function __construct(
        private readonly UploadedFile $image
    ) { }

    public function nameFile(): string
    {
        $data = now()->format('Ymd');
        return "{$this->image->getClientOriginalName()}_{$data}.{$this->image->extension()}";
    }

    public function file(): UploadedFile
    {
        return $this->image;
    }
}
