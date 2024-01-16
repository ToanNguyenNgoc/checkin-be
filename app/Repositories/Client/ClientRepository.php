<?php
namespace App\Repositories\Client;

use App\Repositories\Repository;

class ClientRepository extends Repository implements ClientRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Client::class;
    }
}
