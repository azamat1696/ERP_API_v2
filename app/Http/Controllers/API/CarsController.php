<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SearchCarRequest;
use App\Models\Cars;
use App\Models\CarSeasonsPrice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class CarsController extends Controller
{

    public $seasons = [];
    public function __construct()
    {
        $this->seasons = CarSeasonsPrice::select('StartDate','EndDate','Percentage')->where('Status',true)->orderBy('id','asc')->get();
    }

    public function brands() {
        $query = "SELECT id,BrandName as title, BrandName as description,BrandLogo as logo FROM car_brands  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function models() {
        $query = "SELECT id,brand_id,ModelName as title, ModelLogo as logo FROM car_models  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function bodyTypes() {
        $query = "SELECT id, TypeName as title, TypeName as description  FROM car_body_types  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function classes() {
        $query = "SELECT id, ClassName as title  FROM car_classes  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function fuelTypes() {
        $query = "SELECT id, FuelTypeName as title  FROM car_fuel_types  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function transmissionTypes() {
        $query = "SELECT id, CarTransmissionName as title  FROM car_transmission_types  where Status = 1";
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function types() {
        $records = [
            [
                'id'=>1,
                'title' => 'Small'
            ],
            [
                'id'=>2,
                'title' => 'Medium'
            ],
            [
                'id'=>3,
                'title' => 'Large'
            ],
            [
                'id'=>4,
                'title' => 'Truck'
            ],

            [
                'id'=>5,
                'title' => '4x4'
            ],
            [
                'id'=>6,
                'title' => 'People Carier'
            ],
            [
                'id'=>7,
                'title' => 'Suv'
            ],
            [
                'id'=>8,
                'title' => 'Premium'
            ],
            [
                'id'=>9,
                'title' => 'Convertible'
            ],
            [
                'id'=>10,
                'title' => 'Luxury'
            ],
            [
                'id'=>11,
                'title' => 'Panelvan'
            ]
        ];
        return response()->json($records,200);
    }
    public function searchCar(SearchCarRequest $request) {


        try {
            $record = DB::select($this->filterQuery($request));

            $formatted = [];

            foreach ($record as $item) {

                if ($item->dailyPrice !== null)
                {
                    $item->price1 =  number_format($this->definePrice($request->reservationStartDateTime,$request->reservationEndDateTime, (int)$item->dailyPrice),2) ;
                    $formatted[] = $item;
                }
            }
            return response()->json([
                'message' => 'successfully',
                'status' => 201,
                'payload' =>   $this->arrayPaginator($formatted, $request)
            ], 201);
        } catch (\Exception $exception){
            return response()->json($exception);
        }

    }
    public function filterQuery($request):string
    {
        $imageBaseUrl ="uploads/cars/";

        $commoWhere = '';
        $type = '';
        $transmission ='';
        $fuel = '';

        if($request->filled('type'))
        {
            foreach($request->type as $item)
            {
                $type .=" OR LOWER(cars_v.ClassName) ='{$item}'";
            }
        }

        if($request->filled('transmission'))
        {
            foreach($request->transmission as $item)
            {
                $transmission .=" OR LOWER(cars_v.CarTransmissionName) ='{$item}'";
            }
        }

        if($request->filled('fuel'))
        {
            foreach($request->fuel as $item)
            {
                $fuel .=" OR LOWER(cars_v.FuelTypeName) ='{$item}'";
            }
        }


        $type = substr($type,3);
        $transmission = substr($transmission,3);
        $fuel = substr($fuel,3);

        if($type)
        {
            $commoWhere.= " AND ( ".$type." ) ";
        }


        if($transmission)
        {
            $commoWhere.= " AND ( ".$transmission." ) ";
        }

        if($fuel)
        {
            $commoWhere.= " AND ( ".$fuel." ) ";
        }


        return
            " select
         COUNT(cars_v.car_models_id) as car_model_count_id,
         fwafcv.id,
         fwafcv.offices_id as location_id,
         fwafcv.LicencePlate  as license_plate,
         cars_v.BrandName  as brand_name,
         cars_v.ModelName  as model_name,
         CONCAT('{$imageBaseUrl}',fwafcv.Image)  as url,
         cars_v.Year  as year,
         cars_v.ClassName  as class_name,
         cars_v.TypeName  as car_type_name,
         cars_v.FuelTypeName  as car_fuel_type_name,
         cars_v.CarTransmissionName as transmission_name,
                         FORMAT(fwafcv.DailyPrice,2)  as price1,
        FORMAT(fwafcv.DailyPrice,2)  as  dailyPrice,
         FORMAT(fwafcv.DailyPrice,2)  as price0


          from cars
          left join for_win_app_filtering_cars_view fwafcv on cars.id = fwafcv.id
          left join cars_v on cars.id = cars_v.id
          where
              cars.IsCarArchived = 0 AND cars.IsReserved = 0 AND cars.Status = 1

        AND
(   (
          SELECT SUM(
          (StartDateTime between '{$request->reservationStartDateTime}' AND '{$request->reservationEndDateTime}')
          +
          (DATE_ADD(EndDateTime, INTERVAL 1 DAY) between '{$request->reservationStartDateTime}' AND '{$request->reservationEndDateTime}')
          +
          ('{$request->reservationStartDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 DAY))
          +
          ('{$request->reservationEndDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 DAY))
          )
           from reservations
           where reservations.cars_id = cars.id
          AND ReservationStatus = 'Continues'

          ) is null

          OR

          (
          SELECT SUM(
          (StartDateTime between '{$request->reservationStartDateTime}' AND '{$request->reservationEndDateTime}')
          +
          (DATE_ADD(EndDateTime, INTERVAL 1 DAY) between '{$request->reservationStartDateTime}' AND '{$request->reservationEndDateTime}')
          +
          ('{$request->reservationStartDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 DAY))
          +
          ('{$request->reservationEndDateTime}' between StartDateTime AND DATE_ADD(EndDateTime, INTERVAL 1 DAY))
          )
           from reservations
           where reservations.cars_id = cars.id
          AND ReservationStatus = 'Continues'

          ) = 0 )

          " .$commoWhere ." GROUP BY cars_v.car_models_id";
    }

    public function cars(Request $request) {


        $imageBaseUrl ="uploads/cars/";
        $testQuery =
            " select
         fwafcv.id,
         fwafcv.offices_id as location_id,
         fwafcv.LicencePlate  as license_plate,
         cars_v.BrandName  as brand_name,
         cars_v.ModelName  as model_name,
         CONCAT('{$imageBaseUrl}',fwafcv.Image)  as url,
         cars_v.Year  as year,
         cars_v.ClassName  as class_name,
         cars_v.TypeName  as car_type_name,
         cars_v.FuelTypeName  as car_fuel_type_name,
         (CASE
             WHEN cars_v.CarTransmissionName = 'Automatic' THEN 'Otomatik'
                 WHEN cars_v.CarTransmissionName = 'Manual' THEN 'Manuel'
                    WHEN cars_v.CarTransmissionName = 'Tiptronic' THEN 'Triptonik'
                        ELSE
                            cars_v.CarTransmissionName
             END
             )  as transmission_name,
                         FORMAT(fwafcv.DailyPrice,2)  as price1,
        FORMAT(fwafcv.DailyPrice,2)  as  dailyPrice,
         FORMAT(fwafcv.DailyPrice,2)  as price0
          from cars
          left join for_win_app_filtering_cars_view fwafcv on cars.id = fwafcv.id
          left join cars_v on cars.id = cars_v.id

          ";



        $contents = DB::select($testQuery);
//
//        $total=count($contents);
//        $per_page = 2;
//        $current_page = $request->input("page") ?? 1;
//
//        $starting_point = ($current_page * $per_page) - $per_page;
//
//        $array = array_slice($contents, $starting_point, $per_page, true);
//        return new Paginator($array,$per_page);

      return  $this->arrayPaginator($contents, $request);

    }

    public function arrayPaginator($array, $request)
    {


        $page = $request->page ?? 1; // Get the page=1 from the url
        $perPage = 10; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

       $pagination =  new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, false),
            count($array), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] );
      return   $pagination->toArray();

    }

    public function definePrice($startDateTime,$endDateTime,$price) {

        // 1. aktif olan seasonları al
        // 2. aktif seasonların başlama ve bitiş tarihlerini bir arraya al

        $startDate = Carbon::parse($startDateTime);
        $endDate =  Carbon::parse($endDateTime);

        $periods = CarbonPeriod::create($startDate, $endDate);
        $dateDiff = $startDate->diffInDays($endDate) +1;
        $total = 0;

        foreach ($periods as $period):
//            $result = $this->calculatePieces($period);
            $seasons = json_decode($this->seasons, false, 512, JSON_THROW_ON_ERROR);
            $result =  array_values(array_filter($seasons, static function ($val) use($period): bool {
                $startSeason = Carbon::parse($val->StartDate);
                $endSeason = Carbon::parse($val->EndDate);
                return $startSeason->lte($period) && $endSeason->gte($period);
            }));
            $total += ( ( (int)$result[0]->Percentage / 100) * $price ) + $price;
        endforeach;
        return  $total/$dateDiff;
    }
}
