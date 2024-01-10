<?php

namespace App\Http\Resources\Permission;

use App\Services\Api\PermissionService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionCollection extends ResourceCollection
{
    public function permission()
    {
        return new PermissionService();
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count'         => $this->collection->count(),
            'collection'    => $this->collection->map(function($permissionName) {
                $permission = $this->permission()->repo->getDetailByName($permissionName);

                if ($permission) {
                    return [
                        'id'    => $permission->id,
                        'name'  => $permission->name,
                    ];
                }
            })
        ];
    }
}
