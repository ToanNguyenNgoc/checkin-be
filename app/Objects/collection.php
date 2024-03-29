<?php

namespace App\Http\Resources--CollectionPath--;

use App\Http\Resources\BaseCollection;
use Illuminate\Http\Request;

class --CollectionName-- extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count'         => $this->collection->count(),
            'collection'    => $this->collection->map(function($data) {

            })
        ];
    }
}
