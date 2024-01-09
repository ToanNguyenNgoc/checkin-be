<?php
namespace App\Repositories\Role;

use App\Repositories\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function getRoles($orderByColumn = 'updated_at', $orderByDesc = true, $limit = 0, $paginate = 50);

    public function getCollectionByIds($ids);

    public function getDetailByName($name);
}
