<?php
namespace App\Services\Api;

use App\Models\Client;
use App\Repositories\Client\ClientRepository;
use App\Services\BaseService;

class ClientService extends BaseService
{
    public function __construct()
    {
        $this->repo = new ClientRepository();
    }
}
