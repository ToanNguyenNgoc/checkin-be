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
            $model = $this->init();

            $attrMores = [
                'company_id'            => $this->attributes['company_id'],
                'code'                  => $this->attributes['code'],
                'created_by'            => auth()->user()->id,
                'updated_by'            => auth()->user()->id,
                'main_field_templates'  => $model->buildDefaultMainFieldTemplate(),
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

    public function getFieldTemplate($id)
    {
        $event = $this->find($id);

        if ($event) {
            return [
                'id'            => $event->id,
                'template'      => $event->getFieldTemplate(),
                'main_fields'   => !empty($event->main_field_templates) ? $event->main_field_templates : $event->buildDefaultMainFieldTemplate(),
                'custom_fields' => $event->custom_field_templates
            ];
        }

        return null;
    }

    public function updateFieldTemplate()
    {
        $id = $this->attributes['id'];
        $event = $this->find($id);

        if ($event) {
            /* if (!empty($this->attributes['main_fields']) && count($this->attributes['main_fields'])) {
                foreach ($this->attributes['main_fields'] as $key => $attributes) {

                }
            }

            return [
                'id'            => $event->id,
                'template'      => $event->getFieldTemplate(),
                'main_fields'   => !empty($event->main_field_templates) ? $event->main_field_templates : $event->buildDefaultMainFieldTemplate(),
                'custom_fields' => $event->custom_field_templates
            ]; */
        }

        return null;
    }
}
