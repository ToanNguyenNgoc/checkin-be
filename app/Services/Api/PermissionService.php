<?php
namespace App\Services\Api;

use App\Models\Permission;
use App\Repositories\Permission\PermissionRepository;
use App\Services\BaseService;

class PermissionService extends BaseService
{
    public function __construct()
    {
        $this->repo = new PermissionRepository();
    }

    public function role()
    {
        return new RoleService();
    }

    public function getListFromCurrentUser()
    {
        $permissions = [];
        $userLogin = auth()->user();
        $roles = $userLogin->getRoleNames();

        foreach ($roles as $roleName) {
            $role = $this->role()->repo->getDetailByName($roleName);

            if ($role) {
                $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
            }
        }

        return $permissions;
    }

    public function getListFromRole($roleId)
    {
        $role = $this->role()->find($roleId);

        if ($role) {
            return $role->getPermissionNames();
        }

        return [];
    }

    public function assignToRole()
    {
        $roleId = $this->attributes['role_id'];
        $permissionIds = $this->attributes['permission_ids'];
        $role = $this->role()->find($roleId);

        if ($role) {
            $permissions = $this->repo->getCollectionByIds($permissionIds);
            $role->syncPermissions($permissions);
            return true;
        }

        return false;
    }

    public function revokeFromRole($roleId)
    {
        $permissionIds = $this->attributes['permission_ids'];
        $role = $this->role()->find($roleId);

        if ($role) {
            $permissions = $this->repo->getCollectionByIds($permissionIds);

            foreach ($permissions as $permission) {
                $role->revokePermissionTo($permission);
            }

            return true;
        }

        return false;
    }
}
