<?php

namespace Database\Seeders\test;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name'          => 'view',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'create',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'edit',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'delete',
                'guard_name'    => 'api',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission['name'], $permission['guard_name']);
        }
    }
}
