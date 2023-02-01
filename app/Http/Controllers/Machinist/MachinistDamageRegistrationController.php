<?php

namespace App\Http\Controllers\Machinist;

use App\Exports\Export\CarDamagesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Machinist\MachinistDamageRegistrationRequest;
use App\Models\CarDamage;
use App\Models\Cars;
use App\Models\MachinistDamageRegistration;
use App\Models\MachinistRegistrationCar;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MachinistDamageRegistrationController extends Controller
{
    public function index() {
        
        $records = MachinistDamageRegistration::with('carDamages')->with('car')->get();
         return response()->json($records);
//        return response()->json(MachinistDamageRegistration::all());
    }

    /**
     * @throws \JsonException
     */
    public function store(MachinistDamageRegistrationRequest $request) {
        
      if(count(json_decode($request->validated()['car_damage_ids'], false, 512, JSON_THROW_ON_ERROR)) > 0){
          $item = MachinistDamageRegistration::create([
              'machinist_id' => $request->validated()['machinist_id'],
              'cars_id' => $request->validated()['cars_id'],
              'ReservationStartDate' => $request->validated()['ReservationStartDate'],
              'ReservationEndDate' => $request->validated()['ReservationEndDate'],
              'Description' => $request->validated()['Description'],
              'EstimatedRepairCost' => $request->validated()['EstimatedRepairCost']
          ]);
        $cars =   Cars::find($request->validated()['cars_id']);
              $cars->update(['IsReserved' => 1]) ; 
          $damage_ids = [];
          $damage_status = [];
          foreach (json_decode($request->validated()['car_damage_ids'], true, 512, JSON_THROW_ON_ERROR) as $id)
          {
              $damage_ids[] = [
                  "car_damage_id" => $id,
                  "registration_id" => $item->id
              ];
              $damage_status[] = [
                  "car_damage_id" => $id,
              ];
          }

          $data = MachinistRegistrationCar::insert($damage_ids);
          foreach ($damage_status as $key => $val){
              CarDamage::where('id',$val)->update(['DamageMaintenanceStatus' => 'Processing']);
          }
          // Yukardaki damage idleri proccess'e cevir
          return response()->json([
              "machinist_damage"=>$item,
              "car_damage"=>$data,
          ]);
      }
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' => "Kayıtlı Hasar Seçiniz Lütfen" 
        ];

        throw new HttpResponseException(response()->json($response, 400));
        
    }

    /**
     * @throws \JsonException
     */
    public function update(MachinistDamageRegistrationRequest $request, $id) {
        
        $damage_status_array = explode(",",$request->validated()['car_damage_ids']);
        $damage_ids =[];
        if(($request->validated()['ReservationStatus'] === "Completed") && !empty($request->validated()['car_damage_ids'])){
 
            foreach ($damage_status_array as $key => $val)
            {
                $damage_ids[] = [
                    "car_damage_id" => $val,
                ];
            }
            $item = MachinistDamageRegistration::findOrFail($id);
            $item->update($request->validated());

            foreach ($damage_ids as $key => $val){
                CarDamage::where('id',$val)->update(['DamageMaintenanceStatus' => 'Completed']);
            }
            Cars::where('id',$request->validated()['cars_id'])->update(['IsReserved' => 0]) ;
            return response()->json( $item);
            
        } elseif (($request->validated()['ReservationStatus'] === "Canceled") && !empty($request->validated()['car_damage_ids']))
        {
            foreach ($damage_status_array as $key => $val)
            {
                $damage_ids[] = [
                    "car_damage_id" => $val,
                ];
            }
            $item = MachinistDamageRegistration::findOrFail($id);
            $item->update($request->validated());

            foreach ($damage_ids as $key => $val){
                CarDamage::where('id',$val)->update(['DamageMaintenanceStatus' => 'Waiting']);
            }
            
            Cars::where('id',$request->validated()['cars_id'])->update(['IsReserved' => 0]) ;
            return response()->json( $item );
        }

        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' => "Kayıtlı Hasar Seçiniz Lütfen"
        ];

        throw new HttpResponseException(response()->json($response, 400));



    }

    public function destroy($id){
        $item = MachinistDamageRegistration::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }

    public function show(Request $request, $id) {
        
        return  response()->json($id);
    }

    public function export() {
        return Excel::download(new CarDamagesExport(),'guncel-makinist-reservations.xlsx');
    }
    
    public function activeMachinistRegistrations() {
        $record = DB::table('machinist_export_v')
            ->where('ReservationStatus','=','Opened')
       
             
            ->get();
        return response()->json([
            'records' => $record,
            'count' => $record->count()
        ]);
    }
}
