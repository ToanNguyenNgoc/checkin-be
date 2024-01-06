<?php
namespace App\Repositories\Role;

use App\Repositories\Repository;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Role::class;
    }

    public function getCollectionByIds($ids)
    {
        $query = $this->model->where('enable', true);
        $query = $query->whereIn('id', $ids);
        return $query->get();
    }
}
