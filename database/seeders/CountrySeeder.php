<?php

namespace Database\Seeders;

use App\Services\Api\CountryService;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function country()
    {
        return new CountryService();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = $this->country()->fetchGobalCountry();
        echo $result['msg']."\n";
    }
}
