<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Events\ReservationEndsReminderEvent;
class ReservationEndsReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservationendsreminder:cron';

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
        // Rezervasyon bitiyor bildirimleri
         /*
          * 1. Müşteriye Rezervasyon BITIYOR Hatırlatma SMS Atılacak.
          * 2. Müşteriye Rezervasyon BITIYOR Hatırlatma MAIL Atılacak. => sonra
          * 3. Personele Rezervasyon Bitiyor Mail ve Panel Uygulama Bildirimi Atılacak.
          */
        
//        $endingReservations = DB::select('SELECT * FROM `current_reservations_v` 
//                                                WHERE
//                                                CURRENT_TIMESTAMP >= DATE_SUB(EndDateTime, INTERVAL 3 HOUR) 
//                                                AND ReservationStatus = "ReservationStatus" ');
        $endingReservations = DB::select('SELECT * FROM `old_reservations` WHERE id = 3');
        foreach ($endingReservations as $endingReservation) :
            Event::dispatch(new ReservationEndsReminderEvent($endingReservation));
        endforeach;
        return 0;
    }
}
