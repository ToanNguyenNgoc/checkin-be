<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\PermissionService;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }
}
