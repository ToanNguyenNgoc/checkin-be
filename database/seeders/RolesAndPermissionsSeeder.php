<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /* PERMISSIONS */

        Permission::create(['name' => 'user_role_management:view']);
        Permission::create(['name' => 'user_role_management:create']);
        Permission::create(['name' => 'user_role_management:assign-roles']);
        Permission::create(['name' => 'user_role_management:assign-permissions']);
        Permission::create(['name' => 'user_role_management:revoke-permissions']);

        Permission::create(['name' => 'user_managment:view']);
        Permission::create(['name' => 'user_managment:create']);
        Permission::create(['name' => 'user_managment:update']);
        Permission::create(['name' => 'user_managment:delete']);

        Permission::create(['name' => 'system:view-history']);
        Permission::create(['name' => 'system:restore-default']);

        Permission::create(['name' => 'company:view']);
        Permission::create(['name' => 'company:create']);
        Permission::create(['name' => 'company:update']);
        Permission::create(['name' => 'company:delete']);

        Permission::create(['name' => 'event:view']);
        Permission::create(['name' => 'event:create']);
        Permission::create(['name' => 'event:update']);
        Permission::create(['name' => 'event:config']);
        Permission::create(['name' => 'event:delete']);

        Permission::create(['name' => 'event_asset:view']);
        Permission::create(['name' => 'event_asset:create']);
        Permission::create(['name' => 'event_asset:update']);
        Permission::create(['name' => 'event_asset:delete']);

        Permission::create(['name' => 'organizer:view']);
        Permission::create(['name' => 'organizer:create']);
        Permission::create(['name' => 'organizer:update']);
        Permission::create(['name' => 'organizer:import']);
        Permission::create(['name' => 'organizer:export']);

        Permission::create(['name' => 'client:view']);
        Permission::create(['name' => 'client:create']);
        Permission::create(['name' => 'client:update']);
        Permission::create(['name' => 'client:check-in']);
        Permission::create(['name' => 'client:import']);
        Permission::create(['name' => 'client:delete']);
        Permission::create(['name' => 'client:reset']);
        Permission::create(['name' => 'client:export']);

        Permission::create(['name' => 'checkin:view']);
        Permission::create(['name' => 'checkin:reset']);
        Permission::create(['name' => 'checkin:export']);

        Permission::create(['name' => 'export_log:view']);

        Permission::create(['name' => 'language:view']);
        Permission::create(['name' => 'language:create']);
        Permission::create(['name' => 'language:update']);
        Permission::create(['name' => 'language:define']);
        Permission::create(['name' => 'language:import-definition']);

        Permission::create(['name' => 'country:view']);
        Permission::create(['name' => 'country:update']);
        Permission::create(['name' => 'country:export']);

        Permission::create(['name' => 'campaign:view']);
        Permission::create(['name' => 'campaign:create']);
        Permission::create(['name' => 'campaign:update']);
        Permission::create(['name' => 'campaign:delete']);
        Permission::create(['name' => 'campaign:export']);

        Permission::create(['name' => 'email:view']);
        Permission::create(['name' => 'email:create']);
        Permission::create(['name' => 'email:update']);
        Permission::create(['name' => 'email:send']);
        Permission::create(['name' => 'email:delete']);

        Permission::create(['name' => 'label:view']);
        Permission::create(['name' => 'label:create']);
        Permission::create(['name' => 'label:update']);
        Permission::create(['name' => 'label:delete']);

        Permission::create(['name' => 'card:view']);
        Permission::create(['name' => 'card:create']);
        Permission::create(['name' => 'card:update']);
        Permission::create(['name' => 'card:delete']);

        $permissionAdminToExclude = [
            'user_role_management:view',
            'user_role_management:create',
            'user_role_management:assign-permissions',
            'user_role_management:revoke-permissions'
        ];

        $permissions = Permission::all()->filter(function ($permission) use ($permissionAdminToExclude) {
            return !in_array($permission->name, $permissionAdminToExclude);
        });

        /* ROLES */

        Role::create(['name' => 'system-admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'admin'])->givePermissionTo($permissions);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'device']);

        // or may be done by chaining
        // $role = Role::create(['name' => 'admin'])
        //     ->givePermissionTo(['user_managment:view', 'user_managment:create']);

    }
}
