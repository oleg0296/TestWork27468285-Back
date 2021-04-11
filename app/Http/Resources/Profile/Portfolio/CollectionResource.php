<?php

namespace App\Http\Resources\Profile\Portfolio;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class CollectionResource
 * @package App\Http\Resources\Profile\Portfolio
 */
class CollectionResource extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return ItemResource::collection($this->collection);
    }
}