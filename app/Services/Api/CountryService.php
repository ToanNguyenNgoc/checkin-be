<?php
namespace App\Services\Api;

use App\Models\Country;
use App\Repositories\Country\CountryRepository;
use App\Services\BaseService;

class CountryService extends BaseService
{
    public function __construct()
    {
        $this->repo = new CountryRepository();
    }
}
