<?php

namespace App\Http\Resources\Event;

use App\Helpers\Helper;
use App\Http\Resources\BaseResource;
use App\Services\Api\ClientService;
use Illuminate\Http\Request;

class EventResource extends BaseResource
{
    public function client()
    {
        return new ClientService();
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->attrOnly = [

        ];

        $this->attrMores = [
            'client_count'  => $this->client()->getListByEventId($this->id),
            'from_date'     => Helper::getDateFormat($this->from_date),
            'end_date'      => Helper::getDateFormat($this->end_date),
        ];

        $this->attrExcepts = [
            'main_field_templates',
            'custom_field_templates',
            'languages'
        ];

        return $this->finalizeResult($request);
    }
}
