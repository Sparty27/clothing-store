<?php

namespace App\Services\NovaPoshta;

use App\Models\City;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CityService
{
    public function updateCities(int $page, int $limit)
    {
        $cities = $this->getCities($page, $limit);

        if(!empty($cities) || $cities != false) {
            $this->setCities($cities);
        }
    }

    private function getCities(int $page, int $limit)
    {
        try {
            $response = Http::retry(3, 1000)->timeout(60)->post('https://api.novaposhta.ua/v2.0/json/',[
                'modelName' => 'Address',
                'calledMethod' => 'getCities',
                'methodProperties' => [
                    'Page' => $page,
                    'Limit' => $limit
                ]
            ]);

            $jsonData = $response->json();

            if ($jsonData['success'] === false) {
                throw new Exception(implode(',', $jsonData['warnings']));
            }

            if (empty($jsonData['data'])) {
                return false;
            }

            return $jsonData['data'];
        } catch(Exception $e) {
            Log::error('Помилка з отриманням міст, (CityService->getCities): '.$e->getMessage());
        }

        return false;
    }

    private function setCities(array $cities)
    {
        foreach($cities as $city) {
            $city = City::updateOrCreate(
                [
                    'ref' => $city['Ref'],
                ],
                [
                    'area_id' => $city['Area'],
                    'name' => $city['Description'],
                ]
            );

            $city->updated_at = now();
            $city->save();
        }
    }
}