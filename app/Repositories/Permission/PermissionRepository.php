<?php
namespace App\Repositories\Permission;

use App\Repositories\Repository;

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Permission::class;
    }
}
