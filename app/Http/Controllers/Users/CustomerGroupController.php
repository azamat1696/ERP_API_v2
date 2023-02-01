<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;

use App\Http\Requests\Users\CustomerGroupsRequest;
use App\Models\CustomerGroup;


class CustomerGroupController extends Controller
{
    public function index() {
      
        return response()->json(CustomerGroup::all());
    }
    
    public  function store(CustomerGroupsRequest  $request)
    {
        $item = CustomerGroup::create($request->validated());
        
        return response()->json($item);
    }
    public function update(CustomerGroupsRequest  $request, $id)
    {
        $item = CustomerGroup::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }
}
