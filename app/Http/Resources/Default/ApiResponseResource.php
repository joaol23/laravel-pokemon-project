<?php

namespace App\Http\Resources\Default;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseResource extends JsonResource
{
    public function __construct(
        mixed $resource = [],
        private readonly ?string $message = null,
        private readonly bool $type = true
    ) {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(
        Request $request
    ): array {
        return [
            "data"    => $this->resource,
            "message" => $this->whenNotNull($this->message),
            "type"    => $this->type
        ];
    }
}
