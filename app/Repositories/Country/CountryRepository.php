<?php
namespace App\Repositories\Country;

use App\Repositories\Repository;

class CountryRepository extends Repository implements CountryRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Country::class;
    }

    public function getCountryByCodeAndName($code, $name)
    {
        $query = $this->model->where([
            ['status', '!=', $this->model::STATUS_DELETED],
            ['code', '=', $code],
            ['name', '=', $name],
        ]);

        return $query->first();
    }

    public function getDefaultCountry()
    {
        $query = $this->model->where([
            ['status', '!=', $this->model::STATUS_DELETED],
            ['is_default', '=', true],
        ]);

        return $query->first();
    }
}
