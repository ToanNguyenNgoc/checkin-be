<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    protected $attrOnly;
    protected $attrMores;
    protected $attrExcepts;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count'         => $this->collection->count(),
            'collection'    => parent::toArray($request),
        ];
    }

    public function finalizeResult($request)
    {
        if (!empty($this->attrOnly)) {
            return $this->attrOnly;
        } else {
            $result = parent::toArray($request);

            if (!empty($this->attrMores)) {
                $result = array_merge(parent::toArray($request), $this->attrMores);
            }

            if (!empty($this->attrExcepts)) {
                foreach ($this->attrExcepts as $key) {
                    unset($result[$key]);
                }
            }

            return $result;
        }
    }
}
