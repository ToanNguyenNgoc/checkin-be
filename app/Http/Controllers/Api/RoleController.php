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
            return $this->responseSuccess($model, null);
        } else {
            return $this->responseError([
                'message' => 'Error'
            ], 400);
        }
    }

    public function assign(AssignRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($this->service->assign()) {
            return $this->responseSuccess(null, null);
        } else {
            return $this->responseError([
                'message' => 'Error'
            ], 400);
        }
    }
}
