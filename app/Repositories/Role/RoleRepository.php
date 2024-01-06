<?php
namespace App\Repositories\Role;

use App\Repositories\Repository;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return \Spatie\Permission\Models\Role::class;
    }

    public function getCollectionByIds($ids)
    {
        $query = $this->model->whereIn('id', $ids);
        // $query = $this->model->where('enable', true);
        // $query = $query->whereIn('id', $ids);
        return $query->get();
    }

    public function getDetailByName($name)
    {
        $query = $this->model->where('enable', true);
        $query = $query->where('name', $name);
        return $query->first();
    }
}
