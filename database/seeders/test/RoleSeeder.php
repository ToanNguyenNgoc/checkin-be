<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'          => 'admin',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'user',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'pda',
                'guard_name'    => 'api',
            ],
            [
                'name'          => 'pc',
                'guard_name'    => 'api',
            ],
        ];

        foreach ($roles as $role) {
            Role::findOrCreate($role['name'], $role['guard_name']);
        }
    }
}
