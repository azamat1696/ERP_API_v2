<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CarInspectionsNotifyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carinspectionsnotify:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Cron Job running at ". now());
        
        //**************** ARAÇ MUAYENE TAKİBİ *********************//
        /*
         * 1. Her sabah 08:00 da   bir defa çalışacaktır => ok
         * 2. Muayene tarihi bitimine 5 gün kala kontrol edilecektir database'den => ok
         * 3. Eger bulursa kayıt Notification ziplatacak
         *    a) Aktif Kullanıcılara Mail Gönderme => ok
         *    b) Masaüstü uygulamada Notify Gösterme
         * 4. MYSQL QUERY SELECT cars_id, EndDate FROM `car_inspections` WHERE CURRENT_DATE >= DATE_SUB(EndDate, INTERVAL 5 DAY) AND STATUS = 1 
         */
        
        $endingCarInspections = DB::select('SELECT
                                                  car_inspections.EndDate as InspectionEndDate,
                                                   cars_v.*
                                                   FROM `car_inspections` 
                                                   LEFT JOIN cars_v ON car_inspections.cars_id = cars_v.id
                                                   WHERE 
                                                   CURRENT_DATE >= DATE_SUB(EndDate, INTERVAL 20 DAY) 
                                                   AND
                                                   STATUS = 1');
        
        $activePersonnels = User::where('status',true)->get();
//        foreach ($activePersonnels as $personnel)
//        {
//            // loop through array and check notification
//            return false;
//        }
        foreach ($endingCarInspections as $endingCarInspection)
        {
            Notification::send($activePersonnels,new \App\Notifications\EndingCarInspectionNotification($endingCarInspection));
        }
        return 0;
    }
}
