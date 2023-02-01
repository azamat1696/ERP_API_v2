<?php

namespace App\Http\Controllers\Machinist;

use App\Http\Requests\Machinist\MachinistTypesRequest;
use App\Models\MachinistType;
use App\Http\Controllers\Controller;

class MachinistTypeController extends Controller
{
    public function index() {
        return response()->json(MachinistType::all());
    }
    public function store(MachinistTypesRequest $request) {
        $item = MachinistType::create($request->validated());
        return response()->json($item);

    }
    public function update(MachinistTypesRequest $request,$id) {
        $item = MachinistType::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = MachinistType::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
}
