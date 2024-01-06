<?php
namespace App\Services\Api;

use App\Repositories\Role\RoleRepository;
use App\Services\BaseService;

class RoleService extends BaseService
{
    public function __construct()
    {
        $this->repo = new RoleRepository();
    }

    public function user()
    {
        return new UserService();
    }

    public function create()
    {
        $role = $this->repo->create([
            'name'          => $this->attributes['name'],
            'guard_name'    => $this->attributes['guard_name'] ?? 'api'
        ]);

        return $role;
    }

    public function assign()
    {
        $userId = $this->attributes['user_id'];
        $roleIds = $this->attributes['role_ids'];
        $user = $this->user()->repo->find($userId);

        if ($user) {
            $roles = $this->repo->getCollectionByIds($roleIds);
            $roleNames = $roles->pluck('name')->toArray();
            $user->assignRole($roleNames);
            return true;
        }

        return false;
    }
}
