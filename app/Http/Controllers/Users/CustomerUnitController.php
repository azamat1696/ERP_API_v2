<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CustomerUnitRequest;
use App\Models\CustomerUnit;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Export\CustomerUnitsExport;
class CustomerUnitController extends Controller
{
    public function index() {

        return response()->json(CustomerUnit::all());
    }

    public function store( CustomerUnitRequest $request) {
          $record = CustomerUnit::create($request->validated());
         return response()->json($record);
    }

    public function update(CustomerUnitRequest  $request, $id)
    {
        $item = CustomerUnit::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }
    
    public function export() {
        return Excel::download(new CustomerUnitsExport(),'guncel-makinist-listesi.xlsx');
    }
}
