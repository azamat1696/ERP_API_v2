<?php

namespace App\Http\Controllers\Cars;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\CarClassesRequest;
use App\Models\CarClasses;

class CarClassesController extends Controller
{
    public function index() {
        return response()->json(CarClasses::all());
    }
    public function store(CarClassesRequest $request) {

        $item = CarClasses::create($request->validated());
        return response()->json($item);

    }
    public function update(CarClassesRequest $request,$id) {
        $item = CarClasses::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = CarClasses::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
}
