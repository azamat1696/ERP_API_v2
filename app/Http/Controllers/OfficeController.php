<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\OfficesRequest;
use App\Http\Requests\Settings\OfficesUpdateRequest;
use App\Http\Resources\OfficeResource;
use App\Models\Office;

class OfficeController extends Controller
{
    public function index() {
//        $items =  OfficeResource::collection(Office::all()) ;
        return response()->json(Office::all());
    }
    public function store(OfficesRequest $request) {
 
        $item = Office::create($request->validated());
        return response()->json($item);
    }
    public function update(OfficesUpdateRequest $request,$id) {
        $item = Office::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }
}
