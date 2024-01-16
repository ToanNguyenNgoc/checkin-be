<?php
namespace App\Http\Controllers\Api;

use App\Services\Api\CountryService;
use App\Http\Controllers\Controller;
use Exception;

class CountryController extends Controller
{
    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }

    public function getDefaultCountry()
    {
        
    }

    public function fetchGobalCountry()
    {
        try {
            $result = $this->service->fetchGobalCountry();

            if ($result['success']) {
                return $this->responseSuccess(null, $result['msg']);
            } else {
                return $this->responseError($result['msg']);
            }
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }
}
