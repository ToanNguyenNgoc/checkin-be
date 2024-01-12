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

    public function getList()
    {
        return $this->repo->getRoles(
            $this->attributes['orderBy'] ?? 'updated_at',
            $this->attributes['orderDesc'] ?? true,
            $this->attributes['limit'] ?? null,
            $this->attributes['paginate'] ?? 50
        );
    }

    public function store()
    {
        $id = isset($this->attributes['id']) ? (int)($this->attributes['id']) : null;

        if (empty($id)) {
            $model = $this->repo->create($this->attributes);
        } else {
            $model = $this->repo->find($id);

            if (!empty($model)) {
                $model->update($this->attributes);
            }
        }

        return $model ?? false;
    }

    public function assign()
    {
        $userId = $this->attributes['user_id'];
        $roleIds = $this->attributes['role_ids'];
        $user = $this->user()->find($userId);

        if ($user) {
            $roles = $this->repo->getCollectionByIds($roleIds);

            if (!$roles->isEmpty()) {
                $roleNames = $roles->pluck('name')->toArray();
                $user->syncRoles($roleNames);
                return true;
            }
        }

        return false;
    }
}
