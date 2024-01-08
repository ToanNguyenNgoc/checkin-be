<?php
namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Schema;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    abstract public function getModel();

    public function getFillable()
    {
        return $this->model->getFillable();
    }

    public function getInstanceModel()
    {
        return $this->model;
    }

    public function getModelTable()
    {
        return $this->getInstanceModel()->getTable();
    }

    public function getItem($id, $status = null)
    {
        $query = $this->model->where([
            ['id', '=', $id],
            ['status', '!=', $this->model::STATUS_DELETED],
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

        $item = $query->first();
        return $item;
    }

    public function getList($orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50)
    {
        $query = $this->model;

        if (Schema::hasColumn($this->getModelTable(), 'status')) {
            $query = $query->where('status', '!=', $this->model::STATUS_DELETED);
        }

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

    public function getItems($status = null, $orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50)
    {
        $query = $this->model->where('status', '!=', $this->model::STATUS_DELETED);

        if (!empty($status)) {
            if (is_array($status)) {
                $query = $query->whereIn('status', $status);
            } else {
                $query = $query->where(['status' => $status]);
            }
        }

        if ($orderByDesc) {
            $query = $query->orderBy($orderByColumn, 'desc');
        } else {
            $query = $query->orderBy($orderByColumn, 'asc');
        }

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
        if (Schema::hasColumn($this->getModelTable(), 'status')) {
            return $this->getItem($id, $status);
        } else {
            return $this->model->where([
                'id' => $id
            ])->first();
        }
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);

        if (!empty($result)) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function upsert($attributes = [], $id = null)
    {
        $result = null;

        if (!empty($id)) {
            $result = $this->update($id, $attributes);
        } else {
            $result = $this->create($attributes);
        }

        return $result;
    }

    public function delete($id)
    {
        $result = $this->find($id);

        if (!empty($result)) {
            $result->delete();
            return true;
        }

        return false;
    }

    public function user()
    {
        $user = auth()->user();
        return $user;
    }

    public function userApi()
    {
        $user = auth('api')->user();
        return $user;
    }
}
