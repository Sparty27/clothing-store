<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    public function cities(Request $request)
    {
        $searchTerm = $request->input('q'); // Отримуємо пошуковий термін з Select2

        $cities = City::when($searchTerm, function ($query, $searchTerm) {
            return $query->search($searchTerm);
        })->limit(10)->get();

        return response()->json($cities);
    }

    public function warehouses(Request $request)
    {
        $searchTerm = $request->input('q');

        $relatedOnly = $request->query('relatedOnly');

        $city = City::find($request->query('city'));

        if ($city) {
            $builder = $city->warehouses();
        } elseif ($relatedOnly) {
            return response()->json([]);
        } else {
            $builder = Warehouse::query();
        }

        $warehouses = $builder->when($searchTerm, function ($query, $searchTerm) {
            return $query->search($searchTerm);
        })->limit(10)->get();

        return response()->json($warehouses);
    }
}
