<?php
namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Set model
     */
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

    /**
     * Get a instance of model
     */
    public function getInstanceModel()
    {
        return $this->model;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function getLimitList($limit = 15)
    {
        return $this->model->where('status', '!=', $this->model::STATUS_DELETED)
                            ->orderBy('created_at', 'ASC')
                            ->paginate($limit);
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
                $query = $query->where(['status' => $status]);
            }
        }

        $item = $query->first();

        return $item;
    }

    /**
     * GET list item not limit with status
     */
    public function getItems($status = null, $orderByColumn = 'updated_at', $orderByDesc = true)
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

        return $query->get();
    }

    public function find($id)
    {
        return $this->model->where(['id' => $id])->first();
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

    /**
     * Get instance user
     */
    public function userAdmin()
    {
        $user = auth('admin')->user();
        return $user;
    }

    public function user()
    {
        $user = auth()->user();
        return $user;
    }
}
