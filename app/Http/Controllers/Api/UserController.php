<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {

    }

    public function detail($id)
    {

    }

    public function login(LoginRequest $request)
    {
        
    }
}
