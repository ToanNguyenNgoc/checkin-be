<?php
namespace App\Repositories\Client;

use App\Repositories\RepositoryInterface;

interface ClientRepositoryInterface extends RepositoryInterface
{
    public function getList($searches = [], $filters = [], $orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50);

    public function getListByEventId($eventId, $searches = [], $filters = [], $orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50);

    public function getDetailByEventIdQrcode($eventId, $qrcode, $status = null);

    public function getDetailByQrcode($qrcode, $status = null, $buildQuery = false, $query = null);
}
