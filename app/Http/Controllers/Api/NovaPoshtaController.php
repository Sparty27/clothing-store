<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    public function cities(Request $request, ?City $city)
    {
        if ($city->exists) {
            return response()->json($city);
        }

        $searchTerm = $request->input('q');
        $limit = $request->input('limit', 10);

        $cities = City::when($searchTerm, function ($query, $searchTerm) {
            return $query->search($searchTerm);
        })->limit($limit)->get();

        return response()->json($cities);
    }

    public function warehouses(Request $request, ?Warehouse $warehouse)
    {
        if ($warehouse->exists) {
            return response()->json($warehouse);
        }

        $searchTerm = $request->input('q');
        $limit = $request->input('limit', 10);

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
        })->limit($limit)->get();

        return response()->json($warehouses);
    }
}
