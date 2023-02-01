<?php

namespace App\Http\Controllers\Cars;

use App\Http\Requests\Cars\CarTypesRequest;
use App\Models\CarTypes;
use App\Http\Controllers\Controller;

class CarTypesController extends Controller
{
  public function index() {
      return response()->json(CarTypes::all());
  }
  public function store(CarTypesRequest $request) {
      $item = CarTypes::create($request->validated());
      return response()->json($item);

  }
  public function update(CarTypesRequest $request,$id) {
      $item = CarTypes::findOrFail($id);
      $item->update($request->validated());
      return response()->json($item);
  }

  public function destroy($id){
      $item = CarTypes::findOrFail($id);
      $item->delete();
      return response()->json(true);
  }
}
