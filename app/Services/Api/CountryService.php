<?php
namespace App\Services\Api;

use App\Models\Country;
use App\Repositories\Country\CountryRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Http;

class CountryService extends BaseService
{
    public function __construct()
    {
        $this->repo = new CountryRepository();
    }

    public function fetchGobalCountry()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,flags,cioc');

        if ($response->successful()) {
            $countrys = $response->json();

            if (!empty($countrys) && count($countrys)) {
                foreach ($countrys as $country) {
                    if (!empty($country) && count($country)) {
                        $this->upsertItemByFetchedArray($country);
                    }
                }

                return [
                    'success'   => true,
                    'count'     => count($countrys),
                    'msg'       => count($countrys)." Global Countries Fetched & Updated Successfully"
                ];
            }
        }

        return [
            'success'   => false,
            'msg'       => 'Global Countries List Not Found'
        ];
    }

    private function upsertItemByFetchedArray($country)
    {
        $attibutes = [
            'code'              => !empty($country['cioc']) ? $country['cioc'] : 'undefined',
            'name'              => $country['name']['common'],
            'is_default'        => ($country['name']['common'] == "Vietnam") ? true : false,
            'flag_link'         => $country['flags']['png'],
            'alt'               => !empty($country['flags']['alt']) ? $country['flags']['alt'] : null,
            'description'       => $country['name']['official'],
        ];

        $model = $this->repo->getCountryByCodeAndName($attibutes['code'], $attibutes['name']);

        if (!empty($model)) {
            $model->update($attibutes);
        } else {
            $model = $this->repo->create($attibutes);
        }

        if (!empty($model)) {
            return $model;
        }

        return null;
    }
}
