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
        return $this->storeAs([
            'parent_id'         => $this->attributes['parent_id'] ?? null,
            'is_default'        => $this->attributes['is_default'] ?? false,
            'name'              => $this->attributes['name'],
            'limited_users'     => $this->attributes['limited_users'] ?? null,
            'limited_events'    => $this->attributes['limited_events'] ?? null,
            'limited_campaigns' => $this->attributes['limited_campaigns'] ?? null,
        ], isset($this->attributes['id']) ? [
            'id'                => $this->attributes['id'],
            'status'            => Company::STATUS_ACTIVE
        ] : []);
    }
}
