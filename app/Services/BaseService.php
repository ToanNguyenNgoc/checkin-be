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

    public function getItem($id)
    {
        return $this->repo->getItem($id);
    }

    public function getItemNoStatus($id)
    {
        return $this->repo->getItemNoStatus($id);
    }
}
