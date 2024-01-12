<?php
namespace App\Services\Api;

use App\Repositories\User\UserRepository;
use App\Services\BaseService;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function getList()
    {
        return $this->repo->getList(
            $this->getSearch(),
            $this->getFilters(),
            $this->attributes['orderBy'] ?? 'updated_at',
            $this->attributes['orderDesc'] ?? true,
            $this->attributes['limit'] ?? null,
            $this->attributes['pageSize'] ?? 50
        );
    }

    public function getDetail($id)
    {
        $user = $this->find($id);

        if ($user) {
            return $user;
        }

        return null;
    }
}
