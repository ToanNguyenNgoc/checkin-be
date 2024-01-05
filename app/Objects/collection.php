<?php

namespace App\Http\Resources--CollectionPath--;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

class --CollectionName-- extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->attrOnly = [

        ];

        $this->attrMores = [

        ];

        $this->attrExcepts = [

        ];

        return [
            'count'         => $this->collection->count(),
            'collection'    => $this->finalizeResult($request)
        ];
    }
}
