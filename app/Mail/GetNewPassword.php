<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetNewPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $newPassword;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail,$newPassword)
    {
        $this->details = $userDetail;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('Şifreniz Başarıyla Gönderildi.')-> view('MailTemplates/GetNewPassword');
    }
}
