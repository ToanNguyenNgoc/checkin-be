<?php

namespace App\Http\Resources\User;

use App\Helpers\Helper;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use App\Services\Api\RoleService;

class SelfResource extends BaseResource
{
    public function role()
    {
        return new RoleService();
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rolesWithPermissions = [];
        $roles = $this->getRoleNames();

        foreach ($roles as $roleName) {
            $role = $this->role()->repo->getDetailByName($roleName);

            if ($role) {
                $permissions = $role->getPermissionNames();
            }

            $rolesWithPermissions[$roleName] = $permissions;
        }

        $this->attrMores = [
            'last_login_at' => Helper::getDateTimeFormat($this->last_login_at),
            'roles'         => $rolesWithPermissions,
        ];

        $this->attrExcepts = [
            'email_verified_at'
        ];

        return $this->finalizeResult($request);
    }
}
