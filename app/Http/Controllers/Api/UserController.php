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
}
