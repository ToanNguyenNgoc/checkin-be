<?php
namespace App\Repositories\Organizer;

use App\Repositories\Repository;

class OrganizerRepository extends Repository implements OrganizerRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Organizer::class;
    }
}
