<?php

namespace App\Http\Controllers\Cars;


use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\CarPricesRequest;
use App\Models\CarPrices;
use Illuminate\Support\Facades\DB;
class CarPricesController extends Controller
{
    public function index() {

        return response()
            ->json(DB::table('car_prices_v')->get())
            ;
    }

    public function store(CarPricesRequest $request) {

        $newItem = CarPrices::create($request->validated());
        
        $itemVformatted = DB::table('car_prices_v')->where('id','=',$newItem->id)->first();
        return response()->json($itemVformatted,200);

    }

    public function update(CarPricesRequest $request, $id) {

        $item = CarPrices::findOrFail($id);
        $item->update($request->validated());
        $itemVformatted = DB::table('car_prices_v')->where('id','=',$item->id)->first();
       
        return response()->json($itemVformatted);
    }

}
