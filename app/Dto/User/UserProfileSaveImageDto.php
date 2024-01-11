<?php

namespace App\Dto\User;
use App\Dto\BaseDto;
use App\Dto\UploadFileDtoInterface;
use Illuminate\Http\UploadedFile;

class UserProfileSaveImageDto extends BaseDto implements UploadFileDtoInterface
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
