<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailConfirmNotification extends Notification
{
    use Queueable;
    protected $code;
    protected $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
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
            ->line('Click the button below to verify.')
            ->action(
                'Verify',
                // env('STUDENT_URL') . config('student.url.verification') .
                '?code=' . $this->code . '&email=' . $this->email,
            )
            ->line('Thank you for using our application!');
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
