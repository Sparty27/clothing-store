<?php

namespace App\Services\NovaPoshta;

use Exception;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WarehouseService
{
    public function updateWarehouses(int $page, int $limit)
    {
        $warehouses = $this->getWarehouses($page, $limit);

        if(!empty($warehouses) || $warehouses != false) {
            $this->setWarehouses($warehouses);
        }
    }

    private function getWarehouses(int $page, int $limit)
    {
        try {
            $response = Http::retry(3, 1000)->timeout(60)->post('https://api.novaposhta.ua/v2.0/json/',[
                'modelName' => 'Address',
                'calledMethod' => 'getWarehouses',
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
            Log::error('Помилка з отримання даних відділень, (WarehouseService->getWarehouses): '.$e->getMessage());
        }

        return false;
    }

    private function setWarehouses(array $warehouses)
    {
        foreach($warehouses as $warehouse) {
            $warehouse = Warehouse::updateOrCreate(
                [
                    'ref' => $warehouse['Ref'],
                ],
                [
                    'city_id' => $warehouse['CityRef'],
                    'name' => $warehouse['Description'],
                ]
            );

            $warehouse->updated_at = now();
            $warehouse->save();
        }
    }
}