<?php
namespace App\Repositories\Country;

use App\Repositories\RepositoryInterface;

interface CountryRepositoryInterface extends RepositoryInterface
{
    public function getCountryByCodeAndName($code, $name);

    public function getDefaultCountry();
}
