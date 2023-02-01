<?php

namespace App\Http\Controllers\Address;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\Settings\CountryRequest;


class CountryController extends Controller
{
      public  function  index(){
          return response()->json(Country::all());
      }

      public function store(CountryRequest $request){
          $item = Country::create($request->validated());
          return response()->json($item);
      }

      public function update(CountryRequest $request, $id){

          $items = Country::findOrFail($id);
          $items->update($request->validated());
          return response()->json($items);
      }
      public function destroy($id){
          $item = Country::findOrFail($id);
          $item->delete();
          return response()->json(true);
      }
}
