<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceDetailToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $fileName;
 
    public function __construct( $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('MailTemplates.InvoiceDetail')
            ->attach(public_path('uploads/mail/'.$this->fileName), [
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
