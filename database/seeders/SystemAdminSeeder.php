<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        //     'name'                  => 'System Admin',
        //     'username'              => 'sysadmin',
        //     'email'                 => 'sysadmin@delfi.vn',
        //     'email_verified_at'     => now(),
        //     'password'              => Hash::make('sysadmin@'),
        //     'type'                  => 'ADMIN',
        //     'status'                => 'ACTIVE',
        //     'created_at'            => now(),
        //     'updated_at'            => now()
        // ]);

        $user = User::where('email', 'sschowalter@example.net')->first();
        $role = Role::where('name', 'system-admin')->first();
        $user->assignRole($role);
    }
}
