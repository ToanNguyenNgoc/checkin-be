<?php
namespace App\Services\Api;

use App\Models\Organizer;
use App\Repositories\Organizer\OrganizerRepository;
use App\Services\BaseService;

class OrganizerService extends BaseService
{
    public function __construct()
    {
        $this->repo = new OrganizerRepository();
    }
}
