<?php
namespace App\Http\Controllers--ControllerPath--;

use Illuminate\Http\Request;
use App\Services--ServicePath--;
use App\Models\--ModelName--;
use App\Http\Controllers\Controller;

class --ControllerName-- extends Controller
{
    public function __construct(--ServiceName-- $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        
    }

    public function detail($id)
    {
        
    }
}
