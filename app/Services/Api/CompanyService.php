<?php
namespace App\Services\Api;

use App\Models\Company;
use App\Repositories\Company\CompanyRepository;
use App\Services\BaseService;

class CompanyService extends BaseService
{
    public function __construct()
    {
        $this->repo = new CompanyRepository();
    }

    public function store()
    {
        $attrs = [
            'name'              => $this->attributes['name'],
            'parent_id'         => $this->attributes['parent_id'] ?? null,
            'is_default'        => $this->attributes['is_default'] ?? false,
            'limited_users'     => $this->attributes['limited_users'] ?? null,
            'limited_events'    => $this->attributes['limited_events'] ?? null,
            'limited_campaigns' => $this->attributes['limited_campaigns'] ?? null,
        ];

        if (!isset($this->attributes['id'])) {
            $attrMores['created_by'] = auth()->user()->id;
            $attrMores['updated_by'] = auth()->user()->id;
        } else {
            $attrMores['updated_by'] = auth()->user()->id;
            $attrMores['status'] = Company::STATUS_ACTIVE;
        }

        return $this->storeAs($attrs);
    }
}
