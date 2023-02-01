<?php

namespace App\Http\Controllers\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\CarFuelTypesRequest;
use App\Models\CarFuelTypes;


class CarFuelTypesController extends Controller
{
    public function index() {
        return response()->json(CarFuelTypes::all());
    }
    public function store(CarFuelTypesRequest $request) {

        $item = CarFuelTypes::create($request->validated());
        return response()->json($item);

    }
    public function update(CarFuelTypesRequest $request,$id) {
        $item = CarFuelTypes::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = CarFuelTypes::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
}
