<?php

namespace App\Http\Controllers;



use App\Http\Requests\Cars\CarDamagesRequest;
use App\Models\CarDamage;
use Illuminate\Http\Request;


class CarDamageController extends Controller
{
    public function index() {
        return response()->json(CarDamage::all());
    }
    public function store(CarDamagesRequest $request) {
        $item = CarDamage::create($request->validated());
        return response()->json($item);

    }
    public function update(CarDamagesRequest $request,$id) {
        $item = CarDamage::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = CarDamage::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
    
    public function show( Request $request ,$car_id) {
        
        $items = CarDamage::where('cars_id','=',$car_id)->get();
        return  response()->json($items);
    }
}
