<?php

namespace App\Http\Controllers\Address;

use App\Http\Requests\Settings\DistrictsRequest;
use App\Http\Controllers\Controller;
use App\Models\Districts;
use Illuminate\Support\Facades\Cache;

class DistrictsController extends Controller
{
    protected $cacheName = 'districts';
    
    public function index(){
        
        return response()->json( 
            /*
            Cache::remember($this->cacheName,60*60*24,function () {
            return   Districts::all();
        })
        */
        Districts::all()
        
      );
    }
    
    public function store(DistrictsRequest $request){
        
        $item = Districts::create($request->validated());
        //$cacheItems = Cache::get($this->cacheName);
        //$cacheItems[] = $item;
        //Cache::put($this->cacheName,$cacheItems,60*60*24);
        return response()->json($item);
    }
    public function update(DistrictsRequest $request, $id) {
        
//        $cacheItems =  Cache::get($this->cacheName);
//        $arrayColumn = array_search($id, array_column($cacheItems, 'id'));
        $item = Districts::findOrFail($id);
        $item->update($request->validated());
//        $cacheItems[$arrayColumn] = $item;
//        Cache::put($this->cacheName,$cacheItems,60*60*24);
        return response()->json($item);

    }
    
}
