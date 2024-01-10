<?php
namespace App\Services\Api;

use App\Repositories\Event\EventRepository;
use App\Services\BaseService;
use App\Models\Event;

class EventService extends BaseService
{
    public function __construct()
    {
        $this->repo = new EventRepository();
    }

    public function store()
    {
        $attrs = [
            'name'              => $this->attributes['name'],
            'from_date'         => $this->attributes['from_date'],
            'end_date'          => $this->attributes['end_date'],
            'is_default'        => $this->attributes['is_default'] ?? false,
            'description'       => $this->attributes['description'] ?? null,
            'location'          => $this->attributes['location'] ?? null,
            'note'              => $this->attributes['note'] ?? null,
            'contact_name'      => $this->attributes['contact_name'] ?? null,
            'contact_email'     => $this->attributes['contact_email'] ?? null,
            'contact_phone'     => $this->attributes['contact_phone'] ?? null,
        ];

        if (!isset($this->attributes['id'])) {
            $attrMores = [
                'company_id'    => $this->attributes['company_id'],
                'code'          => $this->attributes['code'],
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id
            ];
        } else {
            $attrMores = [
                'id'            => $this->attributes['id'],
                'updated_by'    => auth()->user()->id,
                'status'        => Event::STATUS_ACTIVE
            ];
        }

        return $this->storeAs($attrs, $attrMores);
    }

    public function assignCompany()
    {
        $id = $this->attributes['id'];
        $event = $this->find($id);

        if ($event) {
            $companyId = $this->attributes['company_id'];

            return $this->storeAs([
                'company_id'    => $companyId
            ], [
                'id'            => $id
            ]);
        }

        return null;
    }
}
