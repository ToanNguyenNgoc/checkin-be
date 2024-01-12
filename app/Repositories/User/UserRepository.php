<?php
namespace App\Repositories\User;

use App\Repositories\Repository;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getList($searches = [], $filters = [], $orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50)
    {
        $query = $this->model->where([
            ['status', '!=', $this->model::STATUS_DELETED],
            ['type', '!=', $this->model::TYPE_SYSTEM_ADMIN]
        ]);

        if ($orderByDesc) {
            $query = $query->orderBy($orderByColumn, 'desc');
        } else {
            $query = $query->orderBy($orderByColumn, 'asc');
        }

        $query = $this->addSearchQuery($query, $searches);
        $query = $this->addFilterQuery($query, $filters);

        if ($limit > 0) {
            $query = $query->limit($limit);
        }

        if ($paginate > 0) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    public function find($id, $status = null)
    {
        $query = $this->model->where([
            ['id', '=', $id],
            ['status', '!=', $this->model::STATUS_DELETED],
            ['type', '!=', $this->model::TYPE_SYSTEM_ADMIN]
        ]);

        if (!empty($status)) {
            if (is_array($status)) {
                $query = $query->whereIn('status', $status);
            } else {
                $query = $query->where([
                    'status' => $status
                ]);
            }
        }

        return $query->first();
    }

    public function checkValidUserStatusByEmail($email)
    {
        $query = $this->model->whereIn('status', $this->model->getStatuesValid());
        $query = $query->where('email', $email);
        return $query->first();
    }
}
