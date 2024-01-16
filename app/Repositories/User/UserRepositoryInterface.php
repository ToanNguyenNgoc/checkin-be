<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getList($orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50, $search = null, $filters = []);

    public function find($id, $status = null);

    public function checkGrantedUserStatusByEmail($email);
}
