<?php

namespace App\Http\Controllers\Cars;

use App\Http\Requests\Cars\CarModelRequest;
use App\Models\CarModel;
use App\Http\Controllers\Controller;
class CarModelController extends Controller
{
    public function index() {

        return response()
            ->json(CarModel::all())
            ;
    }

    public function store(CarModelRequest $request) {

        $newItem = CarModel::create($request->all());
        return response()->json($newItem,200);

    }

    public function update(CarModelRequest $request, $id) {

        $item = CarModel::findOrFail($id);
        $item->update($request->validated());

        return response()->json($item);
    }

    public function destroy($id) {
        $item = CarModel::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
}
