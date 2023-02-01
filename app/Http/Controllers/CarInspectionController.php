<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Cars\CarInspectionsRequest;
use App\Models\CarInspection;
use App\Models\Cars;
class CarInspectionController extends Controller
{

    protected $cars_id;
    public function index() {
        
        $data = DB::select('
                       select 
                       cars_v.LicencePlate,
                       CONCAT(
                           cars_v.BrandName," ",
                           cars_v.ModelName," - ",
                           cars_v.ClassName," ",
                           cars_v.CarTransmissionName," ",
                           cars_v.Year," Model"
                           ) as Car,
                              cars_v.BrandName,
                              cars_v.ModelName,
                              cars_v.ClassName,
                              cars_v.Year,
                              car_inspections.id as id,
                              car_inspections.cars_id,
                              car_inspections.StartDate,
                              car_inspections.EndDate,
                              car_inspections.Cost,
                              car_inspections.Status,
                              car_inspections.Not 
                       from car_inspections  
                           left join cars_v ON car_inspections.cars_id = cars_v.id 
                       where car_inspections.Status = 1');
        return response()->json($data);
    }
    
    public function store(CarInspectionsRequest $request)
    {
        
        $this->cars_id = $request->cars_id;
        $this->closeOldInspections();
        $save = CarInspection::create($request->validated());
        
        $data = DB::select("
         select 
                       cars_v.LicencePlate,
                       CONCAT(
                           cars_v.BrandName,' ',
                           cars_v.ModelName,'-',
                           cars_v.ClassName,' ',
                           cars_v.CarTransmissionName,' ',
                           cars_v.Year,' Model'
                           ) as Car,
                              cars_v.BrandName,
                              cars_v.ModelName,
                              cars_v.ClassName,
                              cars_v.Year,
                              car_inspections.id as id,
                              car_inspections.cars_id,
                              cars_v.CarTransmissionName,
                              car_inspections.StartDate,
                              car_inspections.EndDate,
                              car_inspections.Cost,
                              car_inspections.Status,
                              car_inspections.Not
                       from car_inspections  
                           left join cars_v ON car_inspections.cars_id = cars_v.id 
                       where car_inspections.Status = 1 AND car_inspections.cars_id ='{$save->cars_id}'
                       
                       ");
        return response()->json($data);
    }
    
    public function update(CarInspectionsRequest $request,$id){
        
        $carInspections = CarInspection::find($id);
        $carInspections->update($request->validated());
                $data = DB::select("
                       select 
                       cars_v.LicencePlate,
                       CONCAT(
                           cars_v.BrandName,' ',
                           cars_v.ModelName,'-',
                           cars_v.ClassName,' ',
                           cars_v.CarTransmissionName,' ',
                           cars_v.Year,' Model'
                           ) as Car,
                              cars_v.BrandName,
                              cars_v.ModelName,
                              cars_v.ClassName,
                              cars_v.Year,
                              car_inspections.id as id,
                              car_inspections.cars_id,
                              cars_v.CarTransmissionName,
                              car_inspections.StartDate,
                              car_inspections.EndDate,
                              car_inspections.Cost,
                              car_inspections.Status,
                              car_inspections.Not
                       from car_inspections  
                           left join cars_v ON car_inspections.cars_id = cars_v.id 
                       where car_inspections.Status = 1 AND car_inspections.cars_id ='{$carInspections->cars_id}'
                       
                       ");
                      
        return response()->json($data);
        
    }
    
    
    public function closeOldInspections():void {
        
     $lastCarInspection =    CarInspection::where('cars_id',$this->cars_id)->orderBy('id','DESC')->first();
     if ($lastCarInspection)
     {
         $lastCarInspection->update([
            'Status' => false 
         ]);
     }
    }


    public function multipleSave(Request $request) {

        $cars = Cars::where('CarAttributes',$request->CarAttributes)->where('IsPert',false)->get();
        $inspections=[];
        foreach ($cars as $car) {
            $inspections[]= [
               'cars_id' => $car->id,
                'StartDate' => date('Y-m-d',strtotime($request->StartDate)),
                'EndDate' => date('Y-m-d',strtotime($request->EndDate)),
                'Status' => true,
                'Cost' => $request->Cost,
                'created_at' => date('Y-m-d H:i'),
                'updated_at' => date('Y-m-d H:i'),
            ];
        }

       CarInspection::insert($inspections);
        
        $data = DB::select('
                       select 
                       cars_v.LicencePlate,
                       CONCAT(
                           cars_v.BrandName," ",
                           cars_v.ModelName," - ",
                           cars_v.ClassName," ",
                           cars_v.CarTransmissionName," ",
                           cars_v.Year," Model"
                           ) as Car,
                              cars_v.BrandName,
                              cars_v.ModelName,
                              cars_v.ClassName,
                              cars_v.Year,
                              car_inspections.id as id,
                              car_inspections.cars_id,
                              car_inspections.StartDate,
                              car_inspections.EndDate,
                              car_inspections.Cost,
                              car_inspections.Status,
                              car_inspections.Not 
                       from car_inspections  
                           left join cars_v ON car_inspections.cars_id = cars_v.id 
                       where car_inspections.Status = 1');
        return response()->json($data);
    }
}
