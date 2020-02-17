<?php

namespace FDA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CancelAppointment extends Notification // implements ShouldQueue
{
    use Queueable;
    public $app_id;
    public $company_name;
    public $app_date;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($app_id, $company_name, $app_date)
    {
        $this->app_id = $app_id;
        $this->company_name = $company_name;
        $this->app_date = $app_date;

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
                    ->greeting('Hello, Sir/Madam')
                    ->line("We, ".$this->company_name.' would like to apply cancel application for the appointment taken on '.$this->app_date.'.')
                    ->action('View', route('cancel_appointment_by_admin', [$this->app_id]));
                    // ->action('View', url('admin/cancelAppointment'));
                    // ->line('Thank you for using our application!');
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
