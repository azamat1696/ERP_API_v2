<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndingCarInspectionNotification extends Notification
{
    use Queueable;
    private $car;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($car)
    {
        //
        $this->car = $car;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
                    ->subject('🗓️ Araç Muayene Servis Bildirimi')
                    ->greeting('Araç Muayene Servis Bildirimi')
                    ->line( $this->car->LicencePlate.' - Plakalı araç muayene tarihi sona eriyor.')
                    ->line('Son tarih '.date('d.m.Y',strtotime($this->car->InspectionEndDate)).'. Lütfen Araç Muayene Kayıt İşlemini Yapınız.')
                    ->cc([
                            'ipek.capan@eurocityrentacar.net',
                            'busra.olmez@eurocityrentacar.net',
                            'yusuf.baratov@eurocityrentacar.net'
                        ]);
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
            'cars_id' => $this->car->id,
            'title' => 'Araç Muayene Servisi',
            'message' => $this->car->LicencePlate.' Plakalı araç muayene tarihi yaklaşıyor. Son Tarih: '.date('d.m.Y',strtotime($this->car->InspectionEndDate)),
        ];
    }
}
