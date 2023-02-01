<?php

namespace App\Http\Controllers\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\CarTransmissionsRequest;
use App\Models\CarTransmissionTypes;

class CarTransmissionTypesController extends Controller
{
    public function index() {
        return response()->json(CarTransmissionTypes::all());
    }
    public function store(CarTransmissionsRequest $request) {

        $item = CarTransmissionTypes::create($request->validated());
        return response()->json($item);

    }
    public function update(CarTransmissionsRequest $request,$id) {
        $item = CarTransmissionTypes::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = CarTransmissionTypes::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
}
