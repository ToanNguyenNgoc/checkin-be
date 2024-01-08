<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Api\DeleteRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponser;

    public $service;
    public $cacher;

    public function index(Request $request)
    {
        $this->service->attributes = $request->all();

        if (!empty($list = $this->service->getList())) {
            return $this->responseSuccess(new BaseCollection($list), trans('_response.success.index'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }

    public function detail($id)
    {
        $model = $this->service->find($id);

        if (!empty($model)) {
            return $this->responseSuccess(new BaseResource($model), trans('_response.success.detail'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }

    public function remove($id)
    {
        if ($this->service->remove($id)) {
            return $this->responseSuccess(null, trans('_response.success.delete'));
        } else {
            return $this->responseError([
                'message' => 'Unable to remove item'
            ], 400);
        }
    }

    public function delete($id)
    {
        if ($this->service->delete($id)) {
            return $this->responseSuccess(null, trans('_response.success.delete'));
        } else {
            return $this->responseError([
                'message' => 'Unable to delete item'
            ], 400);
        }
    }
}
