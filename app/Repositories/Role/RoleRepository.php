<?php
namespace App\Repositories\Role;

use App\Repositories\Repository;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return \Spatie\Permission\Models\Role::class;
    }

    public function getRoles($orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50)
    {
        $query = $this->model->where('is_hidden', '=', false);

        if ($orderByDesc) {
            $query = $query->orderBy($orderByColumn, 'desc');
        } else {
            $query = $query->orderBy($orderByColumn, 'asc');
        }

        if ($limit) {
            $query = $query->limit($limit);
        }

        if ($paginate) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    public function getCollectionByIds($ids)
    {
        $query = $this->model->whereIn('id', $ids);

        if (!$this->user()->hasRole('system-admin')) {
            $query = $query->where('is_hidden', '=', false);
        }
        // $query = $this->model->where('enable', true);
        // $query = $query->whereIn('id', $ids);
        return $query->get();
    }

    public function getDetailByName($name)
    {
        $query = $this->model->where('enable', true);

        if (!$this->user()->hasRole('system-admin')) {
            $query = $query->where('is_hidden', '=', false);
        }

        $query = $query->where('name', $name);
        return $query->first();
    }
}
