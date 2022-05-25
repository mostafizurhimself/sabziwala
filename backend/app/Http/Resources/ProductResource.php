<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'code'             => $this->code,
            'category'         => $this->category,
            'zoneId'           => $this->zoneId,
            'zone'             => $this->zone,
            'tags'             => $this->tags,
            'ratings'          => $this->ratings->where('approved', true)->toArray(),
            'averageRatings'   => $this->averageRatings,
            'description'      => $this->description,
            'actualPrice'      => $this->actualPrice,
            'salePrice'        => $this->salePrice,
            'unit'             => $this->unit,
            'isFavourite'      => $this->isFavourite,
            'mediaCollection'  => $this->mediaCollection,
            'thumbnailMediaUrl' => $this->thumbnailMediaUrl,
        ];
    }
}