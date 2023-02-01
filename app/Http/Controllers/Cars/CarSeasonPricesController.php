<?php

namespace App\Http\Controllers\Cars;


use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCarSeasonsPriceRequest;
use App\Http\Requests\UpdateCarSeasonsPriceRequest;
use App\Models\CarSeasonsPrice;
 class CarSeasonPricesController extends Controller
{
    public function index() {

        return response()
            ->json(CarSeasonsPrice::all());
    }

    public function store(StoreCarSeasonsPriceRequest $request) {
      
        $newItem = CarSeasonsPrice::create($request->validated());
        
        return response()->json($newItem,200);

    }

    public function update(UpdateCarSeasonsPriceRequest $request, $id) {

        $item = CarSeasonsPrice::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

}
