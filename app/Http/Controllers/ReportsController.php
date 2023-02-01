<?php

namespace App\Http\Controllers;

use App\Exports\ForAllExports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReservationReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Cars;
class ReportsController extends Controller
{
    public function reservationReport(Request $request) {

  
        $commonQueryPrefix = '';
        
        if ($request->filled('startDateTime'))
        {
    
            $commonQueryPrefix .= " AND r.StartDateTime >= '{$request->startDateTime} 00:00' "; 
        }
        if ($request->filled('endDateTime'))
        {

            $commonQueryPrefix .= " AND r.EndDateTime <= '{$request->endDateTime} 23:59' ";
        }
        if ($request->filled('group_id'))
        {
            $commonQueryPrefix .= " AND r.customer_groups_id = {$request->group_id} ";
        }
        if ($request->filled('licence_plate'))
        {
            $cars = Cars::where('LicencePlate','=',$request->licence_plate)->first();
            $commonQueryPrefix .= " AND r.cars_id = {$cars->id} ";
        }
 
        $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';
            
        $rowsQueryString = 'select
      c.LicencePlate as LicencePlate,
      ReservationNo,
      CONCAT(c.BrandName," ",c.ModelName) as car,
                        (
       case
         when r.customers_id is not null then 
         (select CONCAT(customers.Name," ", customers.Surname) from customers where customers.id = r.customers_id)
         when r.customers_id is null  and r.customers_id is not null then 
         ( select CONCAT(customers.Name," ", customers.Surname) from customers where customers.id = r.customers_id)
         else 
           ""
         end
     ) as Zimmet,
      (
          case
              when  r.ReservationStatus = "Cancelled" then "İptal Edildi"
              when  r.ReservationStatus = "Continues" then "Devam Ediyor"
              when  r.ReservationStatus = "Completed" then "Tamamlandı"
              when  r.ReservationStatus = "WaitingForApproval" then "Onay Bekliyor"
              else
                  r.ReservationStatus
          end
    ) as ReservationStatus,
   
       r.ReservationType,
       cg.Name as CustomerGroupName,

           (
    SELECT
        CONCAT(
            "[",
            GROUP_CONCAT(cd.driver_id SEPARATOR ","),
            "]"
        )
    FROM
         reservation_drivers cd
    WHERE
        cd.reservation_id  = r.id
) AS customers_drivers,
       (select  offices.OfficeName from offices where offices.id = r.drop_office_id) as LocationName,
       DATE_FORMAT(r.EndDateTime, "%d.%m.%Y %H:%i") as EndDateTime,
       DATE_FORMAT(r.StartDateTime, "%d.%m.%Y %H:%i") as StartDateTime,
       CONCAT(r.RentDays," Gün") as RentDays,
       r.TotalPrice,
       r.CurrencyType,
       r.CurrencySymbol,
       r.TotalPriceByCurrency,
       r.CurrencyRate 
 
from reservations r
left join cars_v c on r.cars_id = c.id
left join customer_drivers cd on r.customers_id = cd.customer_id
left join customer_groups cg on r.customer_groups_id = cg.id ' .$commonWhere;

 
        $rows = DB::select($rowsQueryString);

        $currencyRatesQuery = "select (
    SUM(IF(r.CurrencyType = 'Lira',r.TotalPrice,0))
    ) as Lira,
       (
    SUM(IF(r.CurrencyType = 'Dolar',r.TotalPrice,0))
    ) as Dolar,
       (
    SUM(IF(r.CurrencyType = 'Euro',r.TotalPrice,0))
    ) as Euro,

    (
    SUM(IF(r.CurrencyType = 'Sterlin',r.TotalPrice,0))
    ) as Sterlin,
       SUM(r.TotalPriceByCurrency) as TotalPriceByCurrency


from reservations r 
        left join customer_groups cg on r.customer_groups_id = cg.id " .$commonWhere;


        $currencyRatesRecords = DB::select($currencyRatesQuery);
        
        $canvasPrefix = !empty($commonWhere) ? " AND ".substr($commonQueryPrefix,5) : '';
        
        $canvasQuery = "select cg.Name as GroupName, COUNT(cg.id) as count 
                      from reservations r
                      left join customer_groups cg on r.customer_groups_id = cg.id
                      where cg.Name is not null AND r.customer_groups_id is not null {$canvasPrefix}
                      GROUP BY cg.id,cg.Name" ;

     
        $canvasRecords = DB::select($canvasQuery);
        
        return response()->json([
            'rows' => $rows,
            'currencies' => $currencyRatesRecords,
            'canvas' =>$canvasRecords
        ]);
    }
    
    public function reservationReportDownload(Request $request){
        $rows = json_decode($request->rows);
        $headings = json_decode($request->headings);
         return Excel::download(new ReservationReportsExport($rows,$headings),'reservasyonlar raporu.xlsx');
        
    }
    public function exportExelFiles(Request $request){
        $action = $request->input('type');
        $query = '';
        $header = [];
        $commonQueryPrefix = '';
        switch ($action)
        {
            case $action == 'carInspection':

                if ( $request->StartDate != 'undefined' && $request->filled('StartDate'))
                {

                    $commonQueryPrefix .= " AND ci.StartDate >= '{$request->StartDate} 00:00' ";
                }

                if ($request->EndDate != 'undefined' && $request->filled('EndDate'))
                {

                    $commonQueryPrefix .= " AND ci.EndDate <= '{$request->EndDate} 23:59' ";
                }
                $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';

                $query = 'select
       cv.LicencePlate as LicencePlate,
       CONCAT(cv.BrandName," ",cv.ModelName,"-",cv.ClassName," ",cv.CarTransmissionName," ",cv.Year," Model") as Car,
       ci.StartDate as StartDate,
       ci.EndDate as EndDate,
       IF(ci.Status = 1,"Güncel","Eski")  as Status ,
       ci.Cost as Cost,
       ci.`Not` as Notes,
       ci.created_at as CreateDate
   from car_inspections ci
   left join cars_v cv on cv.id = ci.cars_id'.$commonWhere;
                $header = [
                    'PLAKA',
                    'ARAÇ',
                    'BAŞLAMA TARİHİ',
                    'BİTİŞ TARİHİ',
                    'ÜCRETİ',
                    'AÇIKLAMA',
                    'DURUMU',
                    'OLUŞTURMA TARİHİ'
                ];


                return Excel::download(new ForAllExports($query,$header),'Raporlar.xlsx');

            case $action == 'carInsurance';
                if ( $request->StartDate != 'undefined' && $request->filled('StartDate'))
                {

                    $commonQueryPrefix .= " AND ci.StartDateTime >= '{$request->StartDate} 00:00' ";
                }

                if ($request->EndDate != 'undefined' && $request->filled('EndDate'))
                {

                    $commonQueryPrefix .= " AND ci.EndDateTime <= '{$request->EndDate} 23:59' ";
                }
                $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';

                $query = 'select
       cv.LicencePlate as LicencePlate,
        CONCAT(cv.BrandName," ",cv.ModelName,"-",cv.ClassName," ",cv.CarTransmissionName," ",cv.Year," Model") as Car,
       ci.StartDateTime as StartDate,
       ci.EndDateTime as EndDate,
       ci.InsurancePrice as InsurancePrice,
       ci.Note as Note,
       IF(ci.Status = 1,"Güncel","Eski")  as Status ,
       ci.created_at as CreateDate

from car_insurance ci
left join cars_v cv on ci.cars_id = cv.id'.$commonWhere;
                $header = [
                    'PLAKA',
                    'ARAÇ',
                    'BAŞLAMA TARİHİ',
                    'BİTİŞ TARİHİ',
                    'ÜCRETİ',
                    'AÇIKLAMA',
                    'DURUMU',
                    'OLUŞTURMA TARİHİ'
                ];
                return Excel::download(new ForAllExports($query,$header),'Raporlar.xlsx');


            case $action == 'carSeyrusefer';

                if ( $request->StartDate != 'undefined' && $request->filled('StartDate'))
                {
                    $commonQueryPrefix .= " AND css.StartDateTime >= '{$request->StartDate} 00:00' ";
                }
                if ($request->EndDate != 'undefined' && $request->filled('EndDate'))
                {
                    $commonQueryPrefix .= " AND css.EndDateTime <= '{$request->EndDate} 23:59' ";
                }
                $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';

                $query = 'select
       cv.LicencePlate as LicencePlate,
       CONCAT(cv.BrandName," ",cv.ModelName,"-",cv.ClassName," ",cv.CarTransmissionName," ",cv.Year," Model") as Car,
       css.StartDateTime as StartDate,
       css.EndDateTime as EndDate,
       css.SeyruseferPrice as SeyruseferPrice,
       css.Note as Note,
       IF(css.Status = 1,"Güncel","Eski")  as Status ,
       css.created_at     as CreateDate

from car_seyru_sefers css
left join cars_v cv on css.cars_id = cv.id'.$commonWhere;

                $header = [
                    'PLAKA',
                    'ARAÇ',
                    'BAŞLAMA TARİHİ',
                    'BİTİŞ TARİHİ',
                    'ÜCRETİ',
                    'AÇIKLAMA',
                    'DURUMU',
                    'OLUŞTURMA TARİHİ'
                ];
                return Excel::download(new ForAllExports($query,$header),'Raporlar.xlsx');



            case $action == 'carIncome';
                $query = 'SELECT
       cv.LicencePlate as LicencePlate,
       CONCAT(cv.BrandName," ",cv.ModelName,"-",cv.ClassName," ",cv.CarTransmissionName," ",cv.Year," Model") as Car,
       CONCAT(i.amount," ",i.currency_symbol) as Amount,
       i.currency_type as CurrencyType,
       i.note as Note,
       i.ref_code as SapCode,
       (
           CASE
               WHEN i.status = "Approved" THEN "Onaylandı"
               WHEN i.status = "Cancelled" THEN  "İptal Edildi"
               WHEN i.status = "WaitingForApproval" THEN "Onay Bekleniyor"
               ELSE i.status
           END
           ) as Status,
       i.created_at AS CreatedAt

from incomes i
left join cars_v cv on i.cars_id = cv.id';
                $header = [
                    'PLAKA',
                    'ARAÇ',
                    'TUTAR',
                    'PARA BİRİMİ',
                    'AÇIKLAMA',
                    'SAP KODU',
                    'DURUMU',
                    'OLUŞTURMA TARİHİ'
                ];

                return Excel::download(new ForAllExports($query,$header),'Raporlar.xlsx');
            case $action == 'carExpenses';
                $query = 'SELECT
       cv.LicencePlate as LicencePlate,
       CONCAT(cv.BrandName," ",cv.ModelName,"-",cv.ClassName," ",cv.CarTransmissionName," ",cv.Year," Model") as Car,
       CONCAT(e.amount," ",e.currency_symbol) as Amount,
       e.currency_type as CurrencyType,
       e.note as Note,
       e.ref_code as SapCode,
       (
           CASE
               WHEN e.status = "Approved" THEN "Onaylandı"
               WHEN e.status = "Cancelled" THEN  "İptal Edildi"
               WHEN e.status = "WaitingForApproval" THEN "Onay Bekleniyor"
               ELSE e.status
           END
           ) as Status,
       e.created_at AS CreatedAt
from expenses e
left join cars_v cv on e.cars_id = cv.id';
                $header = [
                    'PLAKA',
                    'ARAÇ',
                    'TUTAR',
                    'PARA BİRİMİ',
                    'AÇIKLAMA',
                    'SAP KODU',
                    'DURUMU',
                    'OLUŞTURMA TARİHİ'
                ];
                return Excel::download(new ForAllExports($query,$header),'Raporlar.xlsx');
            default:
                return response()->json();
        }
    }
    public function reservationReportDates(Request $request){

        $commonQueryPrefix = '';

        if ($request->filled('startDate'))
        {
            $commonQueryPrefix .= " AND r.StartDateTime >= '{$request->startDate} 00:00' ";
        }
        if ($request->filled('startEndDate'))
        {

            $commonQueryPrefix .= " AND r.StartDateTime <= '{$request->startEndDate} 23:59' ";
        }

        if ($request->filled('endStartDate'))
        {
            $commonQueryPrefix .= " AND r.EndDateTime >= '{$request->endStartDate} 00:00' ";
        }
        if ($request->filled('endDate'))
        {

            $commonQueryPrefix .= " AND r.EndDateTime <= '{$request->endDate} 23:59' ";
        }

        $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';

        $rowsQueryString = 'select
      c.LicencePlate as LicencePlate,
      ReservationNo,
      CONCAT(c.BrandName," ",c.ModelName) as car,
                        (
       case
         when r.customers_id is not null then 
         (select CONCAT(customers.Name," ", customers.Surname) from customers where customers.id = r.customers_id)
         when r.customers_id is null  and r.customers_id is not null then 
         ( select CONCAT(customers.Name," ", customers.Surname) from customers where customers.id = r.customers_id)
         else 
           ""
         end
     ) as Zimmet,
      (
          case
              when  r.ReservationStatus = "Cancelled" then "İptal Edildi"
              when  r.ReservationStatus = "Continues" then "Devam Ediyor"
              when  r.ReservationStatus = "Completed" then "Tamamlandı"
              when  r.ReservationStatus = "WaitingForApproval" then "Onay Bekliyor"
              else
                  r.ReservationStatus
          end
    ) as ReservationStatus,
   
       r.ReservationType,
       cg.Name as CustomerGroupName,

           (
    SELECT
        CONCAT(
            "[",
            GROUP_CONCAT(cd.driver_id SEPARATOR ","),
            "]"
        )
    FROM
         reservation_drivers cd
    WHERE
        cd.reservation_id  = r.id
) AS customers_drivers,
       (select  offices.OfficeName from offices where offices.id = r.drop_office_id) as LocationName,
       DATE_FORMAT(r.EndDateTime, "%d.%m.%Y %H:%i") as EndDateTime,
       DATE_FORMAT(r.StartDateTime, "%d.%m.%Y %H:%i") as StartDateTime,
       CONCAT(r.RentDays," Gün") as RentDays,
       r.TotalPrice,
       r.CurrencyType,
       r.CurrencySymbol,
       r.TotalPriceByCurrency,
       r.CurrencyRate 
 
from reservations r
left join cars_v c on r.cars_id = c.id
left join customer_drivers cd on r.customers_id = cd.customer_id
left join customer_groups cg on r.customer_groups_id = cg.id ' .$commonWhere;


        $rows = DB::select($rowsQueryString);

        $currencyRatesQuery = "select (
    SUM(IF(r.CurrencyType = 'Lira',r.TotalPrice,0))
    ) as Lira,
       (
    SUM(IF(r.CurrencyType = 'Dolar',r.TotalPrice,0))
    ) as Dolar,
       (
    SUM(IF(r.CurrencyType = 'Euro',r.TotalPrice,0))
    ) as Euro,

    (
    SUM(IF(r.CurrencyType = 'Sterlin',r.TotalPrice,0))
    ) as Sterlin,
       SUM(r.TotalPriceByCurrency) as TotalPriceByCurrency


from reservations r 
        left join customer_groups cg on r.customer_groups_id = cg.id " .$commonWhere;


        $currencyRatesRecords = DB::select($currencyRatesQuery);

        $canvasPrefix = !empty($commonWhere) ? " AND ".substr($commonQueryPrefix,5) : '';

        $canvasQuery = "select cg.Name as GroupName, COUNT(cg.id) as count 
                      from reservations r
                      left join customer_groups cg on r.customer_groups_id = cg.id
                      where cg.Name is not null AND r.customer_groups_id is not null {$canvasPrefix}
                      GROUP BY cg.id,cg.Name" ;


        $canvasRecords = DB::select($canvasQuery);

        return response()->json([
            'rows' => $rows,
            'currencies' => $currencyRatesRecords,
            'canvas' =>$canvasRecords
        ]);
    }
}
