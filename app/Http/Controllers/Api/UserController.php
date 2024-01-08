<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function user()
    {
        return $this->responseSuccess(UserResource::make(auth()->user()), null);
    }

    public function detail($id)
    {
        if ($model = $this->service->getDetail($id)) {
            return $this->responseSuccess(UserResource::make($model), trans('_response.success.detail'));
        } else {
            return $this->responseError([
                'message' => trans('_response.failed.400')
            ], 400);
        }
    }
}
