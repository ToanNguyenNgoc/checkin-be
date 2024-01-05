<?php
namespace App\Services\Api;

use App\Models\Permission;
use App\Repositories\Permission\PermissionRepository;
use App\Services\BaseService;

class PermissionService extends BaseService
{
    public function __construct()
    {
        $this->repo = new PermissionRepository();
    }
}
