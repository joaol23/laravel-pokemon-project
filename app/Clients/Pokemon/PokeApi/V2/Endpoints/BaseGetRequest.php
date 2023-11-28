<?php

namespace App\Clients\Pokemon\PokeApi\V2\Endpoints;

use App\Clients\Pokemon\PokeApi\Interfaces\ApiServiceInterface;
use App\Clients\Pokemon\PokeApi\Interfaces\GetRequestInterface;
use App\Clients\Pokemon\PokeApi\Interfaces\PaginationRequestInterface;
use App\Clients\Pokemon\PokeApi\Interfaces\RequestWithDataInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityListInterface;
use App\Enum\LogsFolder;
use App\Utils\Logging\CustomLogger;

abstract class BaseGetRequest implements GetRequestInterface
{

    public function __construct(
        private readonly ApiServiceInterface $service
    )
    {
    }

    public function get(): EntityInterface|EntityListInterface
    {
        try {
            $dataRequest = $this->getRequestData();
            return $this->transform($this->service
                ->api()
                ->get($this->uri(), $dataRequest)
                ->json());
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage(),
                LogsFolder::API_EXTERNAL_POKEMON
            );
            throw $e;
        }
    }

    abstract protected function uri(): string;

    abstract protected function entity(array $data): EntityInterface|EntityListInterface;

    private function transform(array $data): EntityInterface|EntityListInterface
    {
        return $this->entity($data);
    }

    private function getRequestData(): ?array
    {
        $data = [];
        if ($this instanceof PaginationRequestInterface) {
            $data = [
                "limit" => $this->getLimit(),
                "offset" => $this->getOffset()
            ];
        }

        if ($this instanceof RequestWithDataInterface) {
            $data = array_merge($data, $this->dataRequest());
        }
        return $data;
    }
}
