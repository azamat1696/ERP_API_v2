<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndsReservationReminderToCustomer extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $payload;
    public function __construct($payload)
    {
        $this->payload = $payload;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         return (new MailMessage)
            ->subject('🗓️ Happy Ways Car Rezervasyon')
            ->greeting('Merhaba '.$this->payload->CustomerNameSurname.",")
            ->line( "Happy Ways Car'dan yapmış olduğunuz: ".$this->payload->ReservationNo."'Nolu rezervasyon süresi doluyor.")
            ->line('Son tarih '.date('d.m.Y H:i',strtotime($this->payload->EndDateTime)).'. Bizi tercih ettiginiz için teşekkür ederiz.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
