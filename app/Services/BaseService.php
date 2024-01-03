<?php
namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Exception;
use ZipArchive;

class BaseService
{
    public $attributes;
    public $repo;

    public function init()
    {
        $model = $this->repo->getModel();
        return new $model;
    }

    public function getFillable()
    {
        return $this->repo->getFillable();
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function getItem($id)
    {
        return $this->repo->getItem($id);
    }

    public function getList()
    {
        return $this->repo->getList();
    }

    public function storeAs($attrForms, $attrMores = [])
    {
        $attributes = [];
        $attrPermits = $this->getFillable();

        foreach ($attrPermits as $attrKey) {
            if (isset($attrForms[$attrKey])) {
                $attributes[$attrKey] = $attrForms[$attrKey];
            }
        }

        if (count($attrMores)) {
            $attributes = array_merge($attributes, $attrMores);
        }

        if ($model = $this->repo->upsert($attributes, $attributes['id'])) {
            return $model;
        }

        return null;
    }

    public function store()
    {
        $id = (int)($this->attributes['id']);

        if (empty($id)) {
            $model = $this->repo->create($this->attributes);

            if (!empty($model)) {
                return $model;
            }
        } else {
            $model = $this->repo->find($id);

            if (!empty($model)) {
                $model->update($this->attributes);
                return $model;
            }
        }

        return false;
    }

    public function remove($id)
    {
        $this->attributes = [
            'status' => $this->repo->getModel()::STATUS_DELETED
        ];

        if ($this->repo->update($id, $this->attributes)){
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        if ($this->repo->delete($id)){
            return true;
        }

        return false;
    }
}
