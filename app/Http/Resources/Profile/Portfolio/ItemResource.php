<?php

namespace App\Http\Resources\Profile\Portfolio;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ItemResource
 * @package App\Http\Resources\Profile\Portfolio
 */
class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sum' => $this->sum,
            'currency' => $this->currency,
            'hide' => $this->hide,
        ];
    }
}