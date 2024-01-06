<?php
namespace App\Http\Controllers\Api;

use App\Services\Api\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\AssignRequest;
use App\Http\Requests\Api\Role\StoreRequest;

class RoleController extends Controller
{
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($model = $this->service->create()) {
            return $this->responseSuccess($model, trans('_response.success.store'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }

    public function assign(AssignRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($this->service->assign()) {
            return $this->responseSuccess(null, trans('_response.success.assign'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }
}
