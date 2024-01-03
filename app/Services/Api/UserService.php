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
}
