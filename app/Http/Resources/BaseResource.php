<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
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
    }
}
