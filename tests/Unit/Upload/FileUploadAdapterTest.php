<?php

use App\Dto\UploadFileDtoInterface;
use App\Services\Upload\Adapters\FileUploadAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe("Testando o adapter de upload de arquivos", function () {
    $disk = "public";
    $nameFile = "teste.png";

    beforeEach(function () use ($disk, $nameFile) {
        $this->adapter = new FileUploadAdapter();
        $this->fakeFile = UploadedFile::fake()
            ->image($nameFile);

        Storage::fake($disk);
    });

    test("Testando se salva arquivo corretamente", function () use ($disk, $nameFile) {
        $fileDtoMock = Mockery::mock(UploadFileDtoInterface ::class);

        $fileDtoMock->expects("nameFile")
            ->once()
            ->andReturns($nameFile);

        $fileDtoMock->expects("file")
            ->once()
            ->andReturn($this->fakeFile);

        $this->adapter->save('', $fileDtoMock);

        Storage::disk($disk)
            ->assertExists($nameFile);
    });

    test("Testando se ele vai criar o arquivo no caminho correto", function () use ($disk, $nameFile) {
        $fileDtoMock = Mockery::mock(UploadFileDtoInterface ::class);

        $fileDtoMock->expects("nameFile")
            ->once()
            ->andReturns($nameFile);

        $fileDtoMock->expects("file")
            ->once()
            ->andReturn($this->fakeFile);

        $this->adapter->save('path/to/file', $fileDtoMock);

        $rightPath = 'path/to/file/' . $nameFile;

        Storage::disk($disk)
            ->assertExists($rightPath);
    });
});
