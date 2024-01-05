<?php
namespace App\Http\Controllers\Api;

use App\Services\Api\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Auth\LoginResource;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $this->service->attributes = $request->all();

        if ($this->service->authenticate()) {
            return $this->responseSuccess(LoginResource::make(auth('api')->user()), __('auth.success'));
        } else {
            return $this->responseError(__('auth.failed'), 401);
        }
    }
}
