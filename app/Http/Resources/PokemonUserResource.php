<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            [
                "user_id" => $this->pivot->user_id,
                "order"   => $this->pivot->order
            ],
            (new PokemonResource($this))->toArray($request)
        );
    }
}
