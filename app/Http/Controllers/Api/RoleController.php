<?php
namespace App\Http\Controllers\Api;

use App\Services\Api\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\StoreRequest;

class RoleController extends Controller
{
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request)
    {
        echo 123;
    }
}
