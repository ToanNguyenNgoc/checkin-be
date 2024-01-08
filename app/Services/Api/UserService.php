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

    public function getDetail($id)
    {
        $user = $this->repo->find($id);

        if ($user) {
            return $user;
        }

        return null;
    }
}
