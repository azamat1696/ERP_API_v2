<?php

namespace App\Http\Controllers\Cars;
use App\Exports\Export\CarsExport;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\CarsRequest;
use App\Http\Requests\Cars\CarsUpdateRequest;
use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CarsController extends Controller
{
    protected $filePath;
    protected  $fileName = 'no-image.jpg';
    protected $viewTable = 'for_win_app_filtering_cars_view';
    public function __construct()
    {
        $this->filePath = public_path('uploads/cars');

    }

    public  function index() {
        $cars = Cars::all();
        return response()->json($cars);
    }
    /**
     * @throws \Exception
     */
    public  function store(CarsRequest $request) {
        $validated = $request->safe()->except(['Image']);
        if ($request->hasFile('Image')){
            
            $file = new FileUploader($this->filePath,$request->validated()['Image'],random_int(1111,99999)." -cars");
            $this->fileName = $file->upload();
        }
      
        $item = Cars::create($validated + [  'Image' => $this->fileName, ] );
        return response()->json($item,200);
    }
    public function filterCars(Request $request) {
        
       
        $cars = DB::select($this->filterQuery( $request));
        return response()->json($cars,200);
    }
    public function update(CarsUpdateRequest $request,$id) {
        $validated = $request->safe()->except(['Image']);
         $data = Cars::findOrFail($id);
        if($request->hasFile('Image')){
            if (($data->Image !== $request->validated()['Image'])) // delete old img
            {
                !file_exists($this->filePath . "/" . $data->Image) || unlink($this->filePath . "/" . $data->Image);
                $file = new FileUploader($this->filePath,$request->validated()['Image'],random_int(1111,99999)." -cars");
                $this->fileName = $file->upload();
            
            }
        }
        $data->update($validated + ['Image' => $this->fileName]);
        return response()->json($data);
    }
    
    public function export(){
        return Excel::download(new CarsExport(),'guncel-arabalar-raporu.xlsx');
    }
    
    public function filterQuery($request):string
    {
     $prefixSql = '';
     
      if ($request->filled('brand_id'))
       {
        $prefixSql .= " AND cars.car_brands_id = '{$request->brand_id}' ";
      }

        if ($request->filled('model_id'))
        {
            $prefixSql .= " AND cars.car_models_id = '{$request->model_id}' ";
        }
        if ($request->filled('class_id'))
        {
            $prefixSql .= " AND cars.car_classes_id = '{$request->class_id}' ";
        }

        if ($request->filled('transmission_types_id'))
        {
            $prefixSql .= " AND cars.car_transmission_types_id = '{$request->transmission_types_id}' ";
        }
        return "select
          COUNT(cars_v.car_models_id) as car_model_count_id,
          fwafcv.*
          from cars
          left join for_win_app_filtering_cars_view fwafcv on cars.id = fwafcv.id
          left join cars_v on cars.id = cars_v.id
          where
           cars.IsReserved = 0
          AND cars.Status = 1 
          AND cars.IsCarArchived = 0
          AND
         ( (
          SELECT SUM(
          (StartDateTime between '{$request->StartDateTime}' AND '{$request->EndDateTime}')
          +
          (DATE_ADD(EndDateTime, INTERVAL 1 HOUR) between '{$request->StartDateTime}' AND '{$request->EndDateTime}')
          +
          ('{$request->StartDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 HOUR))
          +
          ('{$request->EndDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 HOUR))
          )
           from reservations
           where reservations.cars_id = cars.id
          AND ReservationStatus = 'Continues'
              
          ) is null {$prefixSql}
             
          OR 
        
          (
          SELECT SUM(
          (StartDateTime between '{$request->StartDateTime}' AND '{$request->EndDateTime}')
          +
          (DATE_ADD(EndDateTime, INTERVAL 1 HOUR) between '{$request->StartDateTime}' AND '{$request->EndDateTime}')
          +
          ('{$request->StartDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 HOUR))
          +
          ('{$request->EndDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 HOUR))
          )
           from reservations
           where reservations.cars_id = cars.id
          AND ReservationStatus = 'Continues'
            
          ) = 0)  {$prefixSql} 
          GROUP BY cars_v.car_models_id
          " ;
    }
    public function filterAssistanceCars($licencePlate) {
        
        
        $cars = DB::table('cars_v')->where('LicencePlate',$licencePlate)->where('IsCarArchived','=','0')->where('Status','=','0')->first();
       if ($cars){
           return response()->json($cars);
       }
       
//        if ($cars)
//        {
//            $checkCars = DB::select("SELECT * FROM cars_v ra where ra.cars_id = {$cars->id} AND ra.Status != 0");
//            if ($checkCars)
//                return response()->json([
//                    'status' => 'failure',
//                    'status_code' => 400,
//                    'message' => 'Bad Request',
//                    'payload' =>  [
//                        'errors' => ['Aracın mevcut asistanlık durumu vardır.']
//                    ],
//                ],400);
//            else
//                return response()->json($cars);
//        }
        return response()->json([
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' =>  [
                'errors' =>[ $licencePlate.' plakalı araç bulunamadı.!']
            ],
        ],400);

    }
    public function getCarsDetails(Request $request){
        
        $cars_v = DB::table('cars_v')->where('isReserved','=',0)->get();
        $cars = DB::table('cars_v')->get();
   
        return response()->json(
            [
                'records' => $cars_v,
                'count' => $cars_v->count(),
                'allCars' => $cars->count(), 
                'allCarsDetails' => $cars 
            ]
        );
    }
    public function findCarByLicencePlate(Request $request){
        $validator =   Validator::make($request->all(),[
            'LicencePlate' => 'required|exists:cars,LicencePlate'
        ]);
        if ($validator->fails())  {
            return response()->json( [
                'status' => 'failure',
                'status_code' => 400,
                'message' => 'Bad Request',
                'payload' => $validator->errors(),
            ],400);
        }

        $cars = DB::table('cars_v')->where('LicencePlate','=',$validator->validated()['LicencePlate'])->where('IsCarArchived','=','0')->first();

        if($cars == null)
        {
            return response()->json( [
                'status' => 'failure',
                'status_code' => 400,
                'message' => 'Bad Request',
                'payload' => 'Araç Bulunamadı'
            ],400);
        }
        return  response()->json($cars);
    }

}
