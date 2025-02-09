<?php

namespace App\Services\NovaPoshta;

use App\Models\Area;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AreaService
{
    public function updateAreas()
    {
        try {
            $areas = $this->getAreas();

            $this->setAreas($areas);
        } catch (Exception $e) {
            Log::error('Помилка з отримання чи оновленням даних областей, (AreaService->updateAreas): '.$e->getMessage());
        }
    }
    public function getAreas(): array
    {
        $response = Http::retry(3, 1000)->timeout(60)->post('https://api.novaposhta.ua/v2.0/json/',
        [
            'modelName' => 'Address',
            'calledMethod' => 'getAreas',
            'methodProperties' => [
                'Page' => 1,
                'Limit' => 100
            ]
        ]);

        $responseData = $response->json();

        if ($responseData['success'] === false) {
            throw new Exception(implode(',', $responseData['warnings']));
        }

        return $responseData['data'];
    }

    public function setAreas(array $areas)
    {
        foreach ($areas as $area)
        {
            Area::updateOrCreate(
                [
                    'ref' => $area['Ref'],
                ],
                [
                    'name' => $area['Description'],
                ]
            );
        }
    }
}