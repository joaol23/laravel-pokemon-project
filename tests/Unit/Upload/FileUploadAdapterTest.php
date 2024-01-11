<?php

use App\Services\Upload\Adapters\FileUploadAdapter;

describe("Testando o adapter de upload de arquivos", function () {

    test("Testando se salva arquivo corretamente", function (){
        $adapter = new FileUploadAdapter();
    });
});
