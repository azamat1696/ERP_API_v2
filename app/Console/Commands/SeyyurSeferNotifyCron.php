<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SeyyurSeferNotifyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seyyursefernotify:cron';

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
        $endingCarInspections = DB::select('SELECT
                                                  car_seyru_sefers.EndDateTime as SeyruSeferEndDate,
                                                   cars_v.*
                                                   FROM `car_seyru_sefers` 
                                                   LEFT JOIN cars_v ON car_seyru_sefers.cars_id = cars_v.id
                                                   WHERE 
                                                   CURRENT_DATE >= DATE_SUB(EndDateTime, INTERVAL 20 DAY) 
                                                   AND
                                                   STATUS = 1');

        $activePersonnel = User::where('status',true)->get();
        foreach ($endingCarInspections as $endingCarInspection)
        {
            Notification::send($activePersonnel,new \App\Notifications\EndingCarSeyruSeferiNotification($endingCarInspection));
        }
        return 0;
    }
}
