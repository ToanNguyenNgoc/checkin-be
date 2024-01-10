<?php
namespace App\Http\Controllers\Api;

use App\Services\Api\EventService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Event\AssignCompanyRequest;
use App\Http\Requests\Api\Event\StoreRequest;
use App\Http\Resources\Event\EventResource;

class EventController extends Controller
{
    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($model = $this->service->store()) {
            return $this->responseSuccess(new EventResource($model), trans('_response.success.store'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }

    public function assignCompany(AssignCompanyRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($this->service->assignCompany()) {
            return $this->responseSuccess(null, trans('_response.success.assign'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }
}
