<?php
namespace App\Repositories\Permission;

use App\Repositories\Repository;

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return \Spatie\Permission\Models\Permission::class;
    }

    public function getCollectionByIds($ids)
    {
        $query = $this->model->whereIn('id', $ids);
        return $query->get();
    }

    public function getDetailByName($name)
    {
        $query = $this->model->where('guard_name', 'api')
            ->where('name', $name);
        return $query->first();
    }
}
