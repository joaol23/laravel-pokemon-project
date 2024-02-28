<?php

namespace App\Http\Resources;

use App\Http\Resources\Default\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollectionResource extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = UserResource::class;

    /**
     * Customize the pagination information for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $paginated
     * @param array $default
     * @return PaginationResource
     */
    public function paginationInformation(
        Request $request, array $paginated, array $default
    ): array {
        return (new PaginationResource($default))
            ->toArray($request);
    }
}
