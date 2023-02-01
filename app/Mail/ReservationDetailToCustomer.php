<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationDetailToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reservationDetail;
    public $carsDetail;
    private $agreementPdf;
    public function __construct($detail,$agreementPdf=null,$carsDetail=null)
    {
        $this->reservationDetail = $detail;
        $this->agreementPdf = $agreementPdf;
        $this->carsDetail = $carsDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return

            $this->agreementPdf
                ?
                $this->view('MailTemplates.ReservationDetail')
                    ->attach(public_path('uploads/mail/'.$this->agreementPdf), [
                        'as' => 'agreement.pdf',
                        'mime' => 'application/pdf',
                    ])
                :
                $this->subject('✅ Rezervasyon Numaranız : #'.$this->reservationDetail->ReservationNo.' İyi eğlenceler... ⭐️')->view('MailTemplates.ReservationDetail')
            ;
    }
}
