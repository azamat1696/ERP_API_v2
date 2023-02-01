<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndingCarSeyruSeferiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $car;
    public function __construct($car)
    {
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
        return ['mail','database'];
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
            ->subject('🗓️ Araç Seyrüsefer Servis Bildirimi')
            ->greeting('Araç Seyrüsefer Servis Bildirimi')
            ->line( $this->car->LicencePlate.' - Plakalı araç seyrüsefer tarihi sona eriyor.')
            ->line('Son tarih '.date('d.m.Y',strtotime($this->car->SeyruSeferEndDate)).'. Lütfen Araç Seyrüsefer Kayıt İşlemini Yapınız.')
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
            'title' => 'Araç Seyrüsefer Ödeme',
            'message' => $this->car->LicencePlate.' Plakalı araç seyrüsefer tarihi yaklaşıyor. Son Tarih: '.date('d.m.Y',strtotime($this->car->SeyruSeferEndDate)),
        ];
    }
}
