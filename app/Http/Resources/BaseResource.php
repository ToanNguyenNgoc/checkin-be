<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected $attrOnly;
    protected $attrMores;
    protected $attrExcepts;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        // DateTime::make('updated_at')->sortable()->readOnly()->serializeUsing(
        //     static fn($value) => Carbon::parse($value)->format(config('app.date_format'))
        // )

        // return array_merge(
        //     parent::toArray($request),
        //     [
        //         'clients_count' => $this->whenLoaded('clients', function () {
        //             return $this->clients->count();
        //         }),
        //         'clients' => ClientResource::collection($this->whenLoaded('clients')),
        //     ]
        // );
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
