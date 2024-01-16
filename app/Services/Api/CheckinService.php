<?php
namespace App\Services\Api;

use App\Models\Checkin;
use App\Repositories\Checkin\CheckinRepository;
use App\Services\BaseService;

class CheckinService extends BaseService
{
    public function __construct()
    {
        $this->repo = new CheckinRepository();
    }
}
