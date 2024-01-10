<?php
namespace App\Repositories\Event;

use App\Repositories\Repository;

class EventRepository extends Repository implements EventRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Event::class;
    }
}
