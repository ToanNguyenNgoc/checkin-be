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

    public function index(Request $request)
    {
        $list = $this->service->getList();

        if (!empty($list)) {
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

    public function remove(DeleteRequest $request)
    {
        if ($this->service->remove($request->id)) {
            return $this->responseSuccess(null);
        } else {
            return $this->responseError([
                'message' => 'Unable to remove item'
            ], 400);
        }
    }

    public function delete(DeleteRequest $request)
    {
        if ($this->service->delete($request->id)) {
            return $this->responseSuccess(null);
        } else {
            return $this->responseError([
                'message' => 'Unable to delete item'
            ], 400);
        }
    }
}
