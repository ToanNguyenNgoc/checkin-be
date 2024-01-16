<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\CountryService;
use App\Models\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function __construct(CountryService $service)
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
