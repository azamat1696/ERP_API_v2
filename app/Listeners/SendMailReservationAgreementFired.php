<?php

namespace App\Listeners;

use App\Events\SendMailReservationAgreement;
use App\Helpers\PrepareMailAgreement;
use App\Mail\ReservationDetailToCustomer;
use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailReservationAgreementFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMailReservationAgreement  $event
     * @return void
     */
    public function handle(SendMailReservationAgreement $event)
    {
        $customer = Reservation::leftJoin('customers',function ($join) {
            $join->on('reservations.customers_id','=','customers.id');
        })->where('reservations.id','=',$event->reservationId)->first();
        $pdf = new PrepareMailAgreement($event->reservationId);
        $detail = [];
        Mail::to($customer->Email)->send(new ReservationDetailToCustomer($detail,$pdf->pdfName));
    }
}
