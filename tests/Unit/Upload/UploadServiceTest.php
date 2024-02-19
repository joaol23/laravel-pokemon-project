<?php

use App\Dto\UploadFileDtoInterface;
use App\Services\Upload\Adapters\UploadAdapterInterface;

describe("Testando service de upload", function () {
    test("Chamar o método save do adapter", function () {
        $mockAdapter = Mockery::mock(UploadAdapterInterface::class);

        $mockAdapter->expects("save")
            ->once()
            ->andReturns('');

        $uploadService = new \App\Services\Upload\UploadService($mockAdapter);

        $uploadService->upload(
            Mockery::mock(UploadFileDtoInterface::class)
            , ''
        );
    });
});
