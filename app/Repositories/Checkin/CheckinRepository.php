<?php
namespace App\Repositories\Checkin;

use App\Repositories\Repository;

class CheckinRepository extends Repository implements CheckinRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Checkin::class;
    }
}
