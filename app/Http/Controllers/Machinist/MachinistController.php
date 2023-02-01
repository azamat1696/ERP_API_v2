<?php

namespace App\Http\Controllers\Machinist;

use App\Exports\Export\MachinistCompaniesExport;
use App\Http\Requests\Machinist\MachinistCompaniesRequest;
use App\Models\Machinist;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class MachinistController extends Controller
{
    public function index() {
        return response()->json(Machinist::all());
    }
    public function store(MachinistCompaniesRequest $request) {

        $item = Machinist::create($request->validated());
        return response()->json($item);

    }
    public function update(MachinistCompaniesRequest $request,$id) {
        
        $item = Machinist::findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id){
        $item = Machinist::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }
    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new MachinistCompaniesExport(),'guncel-makinist-listesi.xlsx');

    }
}
