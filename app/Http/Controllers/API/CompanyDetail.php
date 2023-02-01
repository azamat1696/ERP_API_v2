<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyDetail extends Controller
{
  public function locations() {
      $query = "SELECT id, OfficeName as location_title, OfficeAddress as address_detail,TransferCost as transfer_price,Positions FROM offices where Status = 1" ;
      $records = DB::select($query);
      return response()->json($records,200);
  }

    public function countries() {
        $query = "SELECT id, CountryName as name FROM  countries where Status = 1" ;
        $records = DB::select($query);
        return response()->json($records,200);
    }  
    public function cities() {
        $query = "SELECT id,country_id, CityName as name FROM  cities where Status = 1" ;
        $records = DB::select($query);
        return response()->json($records,200);
    }
    public function extraProducts() {
        $query = "SELECT id,  Name as title,Description as description, Price as price,CalculateType as cal_type FROM  extras where Status = 1" ;
        $records = DB::select($query);
        return response()->json($records,200);
    }
}
