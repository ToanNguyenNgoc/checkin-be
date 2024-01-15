<?php

namespace Database\Seeders\test;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'is_default'        => true,
            'code'              => 'DEFLIVN',
            'name'              => 'Delfi Technologies',
            'contact_email'     => 'delficomvietnam@gmail.com',
            'contact_phone'     => '+84 948 490 070',
            'website'           => 'https://delfi.com.vn/',
            'address'           => '38 Phan Đình Giót, phường 2, Tân Bình, HCM',
            'city'              => 'HCM',
            'limited_users'     => null,
            'limited_events'    => null,
            'limited_campaigns' => null,
        ]);
    }
}
