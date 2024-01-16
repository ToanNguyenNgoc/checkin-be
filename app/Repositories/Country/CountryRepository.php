<?php
namespace App\Repositories\Country;

use App\Repositories\Repository;

class CountryRepository extends Repository implements CountryRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Country::class;
    }
}
