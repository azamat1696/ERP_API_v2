<?php

namespace App\Http\Controllers\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\CitiesRequest;
use App\Models\Cities;

class CitiesController extends Controller
{
    public function index() {
        return response()->json(Cities::all());
    }
    public function store(CitiesRequest $request){
        $item = Cities::create($request->validated());
        return response()->json($item);
    }
    public function update(CitiesRequest $request, $id) {
        
        $items = Cities::findOrFail($id);
        $items->update($request->validated());
        return response()->json($items);
          
    }
}
