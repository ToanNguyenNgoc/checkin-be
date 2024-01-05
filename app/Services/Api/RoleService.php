<?php
namespace App\Services\Api;

use App\Models\Role;
use App\Repositories\Role\RoleRepository;
use App\Services\BaseService;

class RoleService extends BaseService
{
    public function __construct()
    {
        $this->repo = new RoleRepository();
    }
}
