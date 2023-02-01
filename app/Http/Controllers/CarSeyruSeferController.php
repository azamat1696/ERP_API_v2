<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploader;
use App\Http\Requests\Cars\SeyruseferCarsRequest;
use App\Models\CarSeyruSefer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CarSeyruSeferController extends Controller
{
    protected $filePath ;
    public function __construct()
    {
        $this->filePath = public_path('uploads/seyrusefer');
    }

    public function index() {
      
      $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_seyru_sefers.*
from
     car_seyru_sefers

left join cars_v c on car_seyru_sefers.cars_id = c.id

where  car_seyru_sefers.Status = 1');
        
        return response()->json($items);
    }
    
    public function store(SeyruseferCarsRequest $request) {
        $fileName = 'no-image.jpg';
        
      CarSeyruSefer::where('cars_id','=',$request->validated()['cars_id'])->update([ 'Status' => 0 ]);
        
            if($request->hasFile('InvoiceFile'))
            {
                $file = new FileUploader($this->filePath,$request->validated()['InvoiceFile'],Carbon::now()->format('d-m-Y'));
                $fileName = $file->upload();
            }
            $item = CarSeyruSefer::create(['InvoiceFile' => $fileName,] + $request->validated());

         if($item) {
     $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_seyru_sefers.*
from
     car_seyru_sefers

left join cars_v c on car_seyru_sefers.cars_id = c.id

where  car_seyru_sefers.Status = 1 AND car_seyru_sefers.id ='. $item->id );
             return response()->json($items);
}
            
        
  return response()->json([
      'status' => 'failure',
      'status_code' => 400,
      'message' => 'Bad Request1',
      'payload' => 'İşlem Başarısız'
  ]);

    }
    public function update(SeyruseferCarsRequest $request,$id) {
        $carSeyrusefer = CarSeyruSefer::find($id);
        $fileName = $carSeyrusefer->InvoiceFile;
        if ($request->hasFile('InvoiceFile'))
        {
            if ( $carSeyrusefer->InvoiceFile !== 'no-image.jpg') // delete old img
            {
                unlink($this->filePath."/".$carSeyrusefer->InvoiceFile);
            }
            $file = new FileUploader($this->filePath,$request->validated()['InvoiceFile'],Carbon::now()->format('d-m-Y'));
            $fileName = $file->upload();
        }

        $carSeyrusefer->update([  'InvoiceFile' => $fileName, ] +  $request->validated());

        if($carSeyrusefer)
        {
            $items = DB::select('select
     c.LicencePlate,
     c.BrandName,
     c.ModelName,
     c.ClassName,
     c.CarTransmissionName,
     c.Year,
     car_seyru_sefers.*
from
     car_seyru_sefers

left join cars_v c on car_seyru_sefers.cars_id = c.id

where  car_seyru_sefers.Status = 1 AND car_seyru_sefers.id ='. $carSeyrusefer->id );
            
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
        $item = CarSeyruSefer::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }

    public function getCarSeyruseferDownload($id)
    {
        $invoice = CarSeyruSefer::findOrFail($id);
        $filePath = public_path()."/uploads/seyrusefer/".$invoice->InvoiceFile;
        return response()->download($filePath);
    }
}
