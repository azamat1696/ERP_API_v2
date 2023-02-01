<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//use Illuminate\Notifications\Messages\SlackMessage;
class ReservationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $reservation;
    
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
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
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//            ->name($this->reservation['name'])
            ->line($this->reservation['body'])
            ->action($this->reservation['offerText'], $this->reservation['offerUrl'])
            ->line($this->reservation['thanks']);
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
            'reservation_id' => $this->reservation['offer_id']
        ];
    }

//    public function toSlack($notifiable)
//    {
//        return (new SlackMessage)
//            ->content('One of your invoices has been paid!');
//    }
}
