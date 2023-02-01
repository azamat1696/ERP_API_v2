<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtraRequest;
use App\Models\Extra;

class ExtraController extends Controller
{
    public  function index() {
        return response()->json(Extra::all());
    }
     public  function store(ExtraRequest $request)
     {
         $record = Extra::create($request->validated());
         return response()->json($record);
     }
     public function update(ExtraRequest $request,$id)
     {
         $record = Extra::findOrFail($id);
         $record->update($request->validated());
         return response()->json($record);
     }
}
