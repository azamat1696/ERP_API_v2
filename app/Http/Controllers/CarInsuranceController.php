<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploader;
use App\Http\Requests\CarInsuranceRequest;
use App\Models\CarInsurance;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CarInsuranceController extends Controller
{
    protected $filePath ;
    public function __construct()
    {
        $this->filePath = public_path('uploads/insurance');
    }

    public function index() {

        $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_insurance.*
from
     car_insurance

left join cars_v c on car_insurance.cars_id = c.id

where  car_insurance.Status = 1');

        return response()->json($items);
    }

    public function store(CarInsuranceRequest $request) {

        $fileName = 'no-image.jpg';
        
        CarInsurance::where('cars_id','=',$request->validated()['cars_id'])->update([ 'Status' => 0 ]);
        
        if($request->hasFile('InvoiceFile'))
        {
            $file = new FileUploader($this->filePath,$request->validated()['InvoiceFile'],Carbon::now()->format('d-m-Y'));
            $fileName = $file->upload();
        }
        $item = CarInsurance::create(['InvoiceFile' => $fileName,] + $request->validated());
  

        if($item) {
            $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_insurance.*
from
     car_insurance

left join cars_v c on car_insurance.cars_id = c.id

where  car_insurance.Status = 1 AND car_insurance.id ='. $item->id );
            return response()->json($items);
        }


        return response()->json([
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request1',
            'payload' => 'İşlem Başarısız'
        ]);

    }
    public function update(CarInsuranceRequest $request,$id) {
        $carInsurance = CarInsurance::find($id);
        $fileName = $carInsurance->InvoiceFile;
        if ($request->hasFile('InvoiceFile'))
        {
            if ( $carInsurance->InvoiceFile !== 'no-image.jpg') // delete old img
            {
                unlink($this->filePath."/".$carInsurance->InvoiceFile);
            }
            $file = new FileUploader($this->filePath,$request->validated()['InvoiceFile'],Carbon::now()->format('d-m-Y'));
            $fileName = $file->upload();
        }

        $carInsurance->update([  'InvoiceFile' => $fileName, ] +  $request->validated());

        if($carInsurance)
        {
            $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_insurance.*
from
     car_insurance

left join cars_v c on car_insurance.cars_id = c.id

where  car_insurance.Status = 1 AND car_insurance.id ='. $carInsurance->id );

            return response()->json($items);
        }

        return response()->json([
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request1',
            'payload' => 'İşlem Başarısız'
        ]);
    }

    public function destroy($id){
        $item = CarInsurance::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }

    public function getCarInsuranceDownload ($id)
    {
        $invoice = CarInsurance::findOrFail($id);
        $filePath = public_path()."/uploads/insurance/".$invoice->InvoiceFile;
        return response()->download($filePath);
    }

}
